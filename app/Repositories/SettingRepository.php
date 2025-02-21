<?php

namespace App\Repositories;

use App\Models\InvoiceSetting;
use App\Models\Payment;
use App\Models\Setting;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class SettingRepository
 *
 * @version February 19, 2020, 1:45 pm UTC
 */
class SettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'app_name',
        'app_logo',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return Setting::class;
    }

    public function getSyncList()
    {
        return Setting::toBase()->pluck('value', 'key')->toArray();
    }

    public function updateSetting($input): bool
    {
        if (isset($input['invoice_settings'])) {
            $input['currency_after_amount'] = isset($input['currency_after_amount']);
            $input['show_product_description'] = isset($input['show_product_description']) ? true : false;

            $settingInputArray = Arr::only($input, [
                'current_currency', 'currency_after_amount',
                'decimal_separator', 'thousand_separator', 'invoice_no_prefix', 'invoice_no_suffix', 'show_product_description', 'due_invoice_days',
            ]);
        } else {
            $input['mail_notification'] = ($input['mail_notification'] == 1) ? 1 : 0;
            $input['company_phone'] = '+'.$input['prefix_code'].$input['company_phone'];
            $input['country_code'] = '+'.$input['country_code'];
            $input['payment_auto_approved'] = isset($input['payment_auto_approved']);
            $input['show_additional_address_in_invoice'] = isset($input['show_additional_address_in_invoice']);

            if (isset($input['app_logo']) && ! empty($input['app_logo'])) {
                /** @var Setting $setting */
                $setting = Setting::where('key', '=', 'app_logo')->first();
                $setting = $this->uploadSettingImages($setting, $input['app_logo']);
            }
            if (isset($input['favicon_icon']) && ! empty($input['favicon_icon'])) {
                /** @var Setting $setting */
                $setting = Setting::where('key', '=', 'favicon_icon')->first();
                $setting = $this->uploadSettingImages($setting, $input['favicon_icon']);
            }
            if ($input['payment_auto_approved'] == 1) {
                $manualPayments = Payment::wherePaymentMode(Payment::MANUAL)->whereIsApproved(Payment::PENDING)->get();
                foreach ($manualPayments as $manualPayment) {
                    $manualPayment->update(['is_approved' => Payment::APPROVED]);
                }
            }

            $settingInputArray = Arr::only($input, [
                'app_name', 'company_name', 'company_address', 'company_phone',
                'date_format', 'time_format', 'time_zone', 'mail_notification', 'payment_auto_approved', 'country_code',
                'show_product_description', 'city', 'state', 'country', 'zipcode', 'show_additional_address_in_invoice', 'fax_no','vat_no_label','default_language','gst_no'
            ]);
        }

        foreach ($settingInputArray as $key => $value) {
            $setting = Setting::where('key', '=', $key)->first();

            if (empty($setting)) {
                Setting::create([
                    'key' => $key,
                    'value' => $value,
                ]);
            } else {
                $setting->update(['value' => $value]);
            }
        }

        return true;
    }

    public function editSettingsData(): array
    {
        $data = [];
        $timezoneArr = file_get_contents(public_path('timezone/timezone.json'));
        $timezoneArr = json_decode($timezoneArr, true);
        $timezones = [];

        foreach ($timezoneArr as $utcData) {
            foreach ($utcData['utc'] as $item) {
                $timezones[$item] = $item;
            }
        }
        $data['timezones'] = $timezones;
        $data['settings'] = $this->getSyncList();
        $data['dateFormats'] = Setting::DateFormatArray;
        $data['currencies'] = getCurrencies();
        $data['templates'] = Setting::INVOICE__TEMPLATE_ARRAY;
        $data['invoiceTemplate'] = InvoiceSetting::all();

        return $data;
    }

    public function updateInvoiceSetting($input): bool
    {
        try {
            DB::beginTransaction();
            $invoiceSetting = InvoiceSetting::where('key', $input['template'])->first();
            $invoiceSetting->update([
                'template_color' => $input['default_invoice_color'],
            ]);
            /** @var Setting $setting */
            $setting = Setting::where('key', 'default_invoice_template')->first();
            $setting->update([
                'value' => $input['template'],
            ]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($exception->getMessage());
        }

        return true;
    }

    public function uploadSettingImages($setting, $value): mixed
    {
        $setting->clearMediaCollection(Setting::PATH);
        $media = $setting->addMedia($value)->toMediaCollection(Setting::PATH, config('app.media_disc'));
        $setting = $setting->refresh();
        $setting->update(['value' => $media->getFullUrl()]);

        return $setting;
    }
}
