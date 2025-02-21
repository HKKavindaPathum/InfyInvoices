    <script id="defaultTemplate" type="text/x-jsrender">
        <?php
        $styleCss = 'style';
        ?>
        <div class="container-fluid">
            <div class="mb-8">
                <img src="<?php echo getLogoUrl() ?>"class="img-logo" alt="logo">
            </div>
            <div>
                <div class="overflow-auto w-100 mb-15">
                    <table class="table table-bordered w-100" style="white-space: nowrap;">
                        <thead>
                            <tr>
                                <th class="py-1 text-capitalize" style="width:33.33% !important;">
                                    <strong><?php echo __('messages.common.from') ?></strong>
                                </th>
                                <th class="py-1 text-capitalize" style="width:33.33% !important;">
                                    <strong><?php echo __('messages.common.to') ?></strong>
                                </th>
                                <th class="py-1 text-capitalize" style="width:33.33% !important;">
                                    <strong><?php echo __('messages.common.invoice') ?></strong>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-1">
                                    <p class="p-text mb-1"><strong><?php echo __('messages.common.name') ?>:</strong> <span>{{:companyName}}</span></p>
                                    <p class="p-text mb-1"><strong><?php echo __('messages.common.address')  ?>:</strong> <span>{{:companyAddress}}</span></p>
                                    <p class="p-text mb-1"><strong><?php echo __('messages.user.phone')  ?>:</strong> <span>{{:companyPhone}}</span></p>
                                    <p class="p-text mb-1"><strong><?php echo getVatNoLabel() ?>:</strong> <span>{{:gstNo}}</span></p>
                                </td>
                                <td class="py-1" style=" overflow:hidden; word-wrap: break-word;word-break: break-all;">
                                    <p class="p-text mb-3">&lt<?php echo __('messages.invoice.client_name')  ?>&gt</p>
                                    <p class="p-text mb-3">&lt<?php echo __('messages.invoice.client_email')  ?>&gt</p>
                                    <p class="p-text mb-3">&lt<?php echo __('messages.client_address')  ?>&gt</p>
                                    <p class="p-text mb-3">&lt<?php echo getVatNoLabel() ?>&gt</p>
                                </td>
                                <td class="py-1">
                                    <p class="text-nowrap font-color-gray"><b><?php echo __('messages.invoice.invoice_id') ?>:</b> #9CQ5X7</p>
                                    <div class="mb-3">
                                        <p class="p-text mb-0"><b><?php echo __('messages.invoice.invoice_date') ?>: </b>25/09/2020</p>
                                    </div>
                                    <div>
                                        <p class="p-text mb-0"><b><?php echo __('messages.invoice.due_date') ?>: </b> 26/09/2020</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="py-1" style="width:6%;"><strong>#</strong></th>
                                <th class="py-1 text-uppercase" style="width:40%;"><strong><?php echo __('messages.item') ?></strong></th>
                                <th class="py-1 text-uppercase text-center" style="width:12%;"><strong><?php echo __('messages.invoice.qty') ?></strong></th>
                                <th class="py-1 text-uppercase text-center"  style="width:14%;"><strong><?php echo __('messages.product.unit_price') ?></strong></th>
                                <th class="py-1 text-uppercase text-center"  style="width:14%;"><strong><?php echo __('messages.invoice.tax') . '(in %)' ?></strong></th>
                                <th class="py-1 text-uppercase" style="width:14%;"><strong><?php echo __('messages.invoice.amount') ?></strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span>1</span></td>
                                <td class="text-start"><p class="mb-0"><?php echo __('messages.item') ?> 1</p><?php echo __('messages.Description') ?></td>
                                <td class="text-center"> 1</td>
                                <td class="text-center"><?php echo getCurrencyAmount(100, true) ?></td>
                                <td class="text-center">N/A</td>
                                <td><?php echo getCurrencyAmount(100, true) ?></td>
                            </tr>
                            <tr>
                                <td><span>2</span></td>
                                <td class="text-start"><p class="mb-0"><?php echo __('messages.item') ?> 2</p><?php echo __('messages.Description') ?></td>
                                <td class="text-center"> 1</td>
                                <td class="text-center"><?php echo getCurrencyAmount(100, true) ?></td>
                                <td class="text-center">N/A</td>
                                <td><?php echo getCurrencyAmount(100, true) ?></td>
                            </tr>
                            <tr>
                                <td><span>3</span></td>
                                <td class="text-start"><p class="mb-0"><?php echo __('messages.item') ?> 3</p><?php echo __('messages.Description') ?></td>
                                <td class="text-center"> 1</td>
                                <td class="text-center"><?php echo getCurrencyAmount(100, true) ?></td>
                                <td class="text-center">N/A</td>
                                <td><?php echo getCurrencyAmount(100, true) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table class="mb-6 mt-10 w-100">
                    <tr>
                        <td class="w-75">
                            <div>
                                <small  style="font-size: 15px; margin-bottom: 3px"><b><?php echo __('messages.payment_qr_codes.payment_qr_code') ?></b></small><br>
                                <img class="mt-2" src="<?php echo asset('images/qrcode.png') ?>" height="110" width="110">
                            </div>
                        </td>
                        <td class="w-25 text-end">
                            <table>
                                <tbody class="text-end">
                                    <tr>
                                        <td>
                                            <strong><?php echo __('messages.invoice.amount') ?>:</strong>
                                        </td>
                                        <td>
                                            <?php echo getCurrencyAmount(300, true) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong><?php echo __('messages.invoice.discount') ?>:</strong>
                                        </td>
                                        <td>
                                            <?php echo getCurrencyAmount(50, true) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong ><?php echo __('messages.invoice.tax') ?>:</strong>
                                        </td>
                                        <td>0%</td>
                                    </tr>
                                    <tr>
                                        <td><strong ><?php echo __('messages.invoice.total') ?>:</strong></td>
                                        <td class="text-nowrap">
                                            <?php echo getCurrencyAmount(250, true) ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="alert alert-light text-muted mb-10">
                    <h4 class="d-fancy-title mb5"><?php echo __('messages.client.notes') ?>:</h1>
                    <p class="font-color-gray">
                        Paypal , Stripe & manual payment method accept.<br>
                        Net 10 – Payment due in 10 days from invoice date.<br>
                        Net 30 – Payment due in 30 days from invoice date.
                    </p>
                </div>
                <div class="text-muted">
                    <h4 class="d-fancy-title mb5"><?php echo __('messages.invoice.terms') ?>:</h1>
                    <p class="font-color-gray">Invoice payment <?php echo __('messages.invoice.total') ?> ; 1% 10 Net 30, 1% discount if payment received within 10 days otherwise payment 30 days after invoice date.</p>
                </div>
            </div>
        </div>
    </script>

    <script id="newYorkTemplate" type="text/x-jsrender">
        <?php
        $styleCss = 'style';
        ?>
        <div class="container">
            <div class="invoice-header d-flex justify-content-between">
                <div class="mb-8" style="vertical-align:top !important;">
                <img src="<?php echo getLogoUrl() ?>"class="img-logo" alt="logo">
                </div>
                <div class="invoice-header-inner">
                    <div class="d-title" style="color:{{:invColor}};"><strong><?php echo __('messages.common.invoice') ?></strong></div>
                    <p class="text-end">#9B5QX7</p>
                </div>
            </div>
            <div class="details-section">
                <div class="overflow-auto mb-15">
                    <table class="w-100 mb-15"  style="white-space:nowrap;">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="vertical-align:top !important; width:33.33% !important; border-top: 1px solid #c0c0c0; border-right: 1px solid #c0c0c0;
                                    border-bottom: 1px solid #c0c0c0; padding: 15px 20px;">
                                    <div class="mb-2">
                                        <strong class="font-size-15"><?php echo __('messages.invoice.invoice_date') ?>:</strong>
                                        <p class="p-text mb-0"><strong class="font-size-15"></strong>2020.09.25</p>
                                    </div>
                                    <div>
                                        <strong class="font-size-15"><?php echo __('messages.invoice.due_date') ?>: </strong>
                                        <p class="p-text mb-0"><b></b>2020.09.26</p>
                                    </div>
                                </td>
                                <td style="vertical-align:top !important; width:33.33% !important; overflow:hidden; word-wrap: break-word; word-break: break-all;  padding: 15px 20px;
                                    border-top: 1px solid #c0c0c0;
                                    border-right: 1px solid #c0c0c0;
                                    border-bottom: 1px solid #c0c0c0;">
                                    <p class="p-text mb-2"><b><?php echo __('messages.common.to') ?>:</b></p>
                                    <p class="p-text">&lt<?php echo __('messages.invoice.client_name')  ?>&gt</p>
                                    <p class="p-text">&lt<?php echo __('messages.invoice.client_email')  ?>&gt</p>
                                    <p class="p-text">&lt<?php echo __('messages.client_address')  ?>&gt</p>
                                    <p class="p-text">&lt<?php echo getVatNoLabel() ?>&gt</p>
                                </td>
                                <td style="vertical-align:top !important; width:33.33% !important; padding: 15px 20px;
                                    border-top: 1px solid #c0c0c0;
                                    border-left: 1px solid #c0c0c0;
                                    border-bottom: 1px solid #c0c0c0;">
                                    <p class="p-text mb-2"><b><?php echo __('messages.common.from') ?>:</b></p>
                                    <p class="p-text mb-1"><strong><?php echo __('messages.common.name') ?>:</strong> <span>{{:companyName}}</span></p>
                                    <p class="p-text mb-1"><strong><?php echo __('messages.common.address')  ?>:</strong> <span>{{:companyAddress}}</span></p>
                                    <p class="p-text mb-1"><strong><?php echo __('messages.user.phone')  ?>:</strong> <span>{{:companyPhone}}</span></p>
                                    <p class="p-text mb-1"><strong><?php echo getVatNoLabel() ?>:</strong> <span>{{:gstNo}}</span></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="overflow-auto w-100"">
                    <table class="table w-100" style="border-bottom: 1px solid {{:invColor}};">
                        <thead style="border-bottom: 1px solid {{:invColor}} !important;  border-top: 1px solid {{:invColor}};">
                            <tr>
                                <th class="py-1" style="width:5%;"><strong>#</strong></th>
                                <th class="py-1"><strong><?php echo __('messages.item') ?></strong></th>
                                <th class="py-1 text-center" style="width:8%;"><strong><?php echo __('messages.invoice.qty') ?></strong></th>
                                <th class="py-1 text-center"  style="width:12%;"><strong><?php echo __('messages.product.unit_price') ?></strong></th>
                                <th class="py-1 text-center"  style="width:12%;"><strong><?php echo __('messages.invoice.tax') . '(in %)' ?></strong></th>
                                <th class="py-1 text-end" style="width:12%;"><strong><?php echo __('messages.invoice.amount') ?></strong></th>
                            </tr>
                        </thead>
                        <tbody style="border: 0px solid white !important;">
                            <tr>
                                <td><span>1</span></td>
                                <td><p class="mb-0"><?php echo __('messages.item') ?> 1</p><?php echo __('messages.Description') ?></td>
                                <td class="text-center"> 1</td>
                                <td class="text-end text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                <td class="py-1 text-center">N/A</td>
                                <td class="text-end text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                            </tr>
                            <tr>
                                <td><span>2</span></td>
                                <td><p class="mb-0"><?php echo __('messages.item') ?> 2</p><?php echo __('messages.Description') ?></td>
                                <td class="text-center"> 1</td>
                                <td class="text-end text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                <td class="py-1 text-center">N/A</td>
                                <td class="text-end text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                            </tr>
                            <tr>
                                <td><span>3</span></td>
                                <td><p class="mb-0"><?php echo __('messages.item') ?> 3</p><?php echo __('messages.Description') ?></td>
                                <td class="text-center"> 1</td>
                                <td class="text-end text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                <td class="py-1 text-center">N/A</td>
                                <td class="text-end text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table class="w-100">
                    <tr>
                        <td class="w-65" style="vertical-align:bottom !important;>
                            <div>
                                <small style="font-size: 15px; margin-bottom: 3px"><b><?php echo __('messages.payment_qr_codes.payment_qr_code') ?></b></small><br>
                                <img style="margin-left: 8px" src="<?php echo asset('images/qrcode.png') ?>" height="110" width="110">
                            </div>
                        </td>
                        <td class="text-end" style="width:35%;">
                            <table class="total-table table w-100">
                                <tbody>
                                    <tr style="border-bottom: 1px solid {{:invColor}} !important;">
                                        <td>
                                            <strong><?php echo __('messages.invoice.amount') ?>:</strong>
                                        </td>
                                        <td class="text-nowrap">
                                            <?php echo getCurrencyAmount(300, true) ?>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid {{:invColor}} !important;">
                                        <td>
                                            <strong><?php echo __('messages.invoice.discount') ?>:</strong>
                                        </td>
                                        <td class="text-nowrap">
                                            <?php echo getCurrencyAmount(50, true) ?>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid {{:invColor}} !important;">
                                        <td>
                                            <strong ><?php echo __('messages.invoice.tax') ?>:</strong>
                                        </td>
                                        <td>N/A</td>
                                    </tr>

                                    <tr style="border-bottom: 1px solid {{:invColor}} !important;">
                                        <td><strong ><?php echo __('messages.invoice.total') ?>:</strong></td>
                                        <td class="text-nowrap">
                                            <?php echo getCurrencyAmount(250, true) ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
                <div  style="margin-top: 40px !important;">
                    <p><b><?php echo __('messages.client.notes') ?>:</b></p>
                    <p class="font-color-gray">
                        Paypal , Stripe & manual payment method accept. Net 10 – Payment due in 10 days from invoice date. Net 30 – Payment due in 30 days from invoice date.
                    </p>
                </div>
                <div>
                    <p mb5"><b><?php echo __('messages.invoice.terms') ?>:</b></p>
                    <p class="font-color-gray">Invoice payment <?php echo __('messages.invoice.total') ?> ; 1% 10 Net 30, 1% discount if payment received within 10 days otherwise payment 30 days after invoice date.</p>
                </div>
                <div class="regards">
                <p><b><?php echo __('messages.setting.regards') ?>:</b><br>
                    <b style="color:{{:invColor}} !important;">{{:companyName}}</b>
                </p>
            </div>
            </div>
        </div>
    </script>

    <script id="torontoTemplate" type="type/x-jsrender">
        <div class="preview-main client-preview">
            <div class="d" id="boxes">
                <div>
                    <div class="mb-8 p-5" style="background-color:#F9F9F9; ">
                        <table >
                            <tr>
                                <td class="position-relative w-50" style="vertical-align:top;">
                                    <div>
                                        <img src="<?php echo getLogoUrl() ?>" class="img-logo" alt="logo">
                                    </div>
                                    <div class="position-absolute bottom-0 left-0 mb-5">
                                        <img class="mt-2" src="<?php echo asset('images/qrcode.png') ?>" height="100" width="100">
                                    </div>
                                </td>
                                <td>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="f-b">
                                                    <p  style="color:{{:invColor}};"><strong><?php echo __('messages.common.invoice') ?></strong></p>
                                                </th>
                                                <th class="f-b"><p  style="color:{{:invColor}};">#9CQ5X7</p></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p class="m-0 fw-bold fs-6"><?php echo __('messages.invoice.invoice_date') ?></p>
                                                    <p>2022-01-01</p>
                                                </td>
                                                <td>
                                                    <p class="m-0 fw-bold fs-6"><?php echo __('messages.invoice.due_date') ?></p>
                                                    <p>2022-01-01</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align:top;>
                                                    <span class="m-0 fw-bold fs-6"><strong><?php echo __('messages.common.from') ?></strong></span><br>
                                                    <span>{{:companyName}}</span><br>
                                                    <span>
                                                        {{:companyAddress}}
                                                    </span><br>
                                                    <span>1234567890</span><br>
                                                    <span>{{:gstNo}}</span>
                                                </td>
                                                <td style="vertical-align:top;>
                                                    <span class="m-0 fw-bold fs-6"><strong><?php echo __('messages.common.to') ?></strong></span><br>
                                                    <span>&lt<?php echo __('messages.invoice.client_name')  ?>&gt</span><br>
                                                    <span>&lt<?php echo __('messages.invoice.client_email')  ?>&gt</span><br>
                                                    <span>&lt<?php echo __('messages.client_address')  ?>&gt</span><br>
                                                    <span>&lt<?php echo getVatNoLabel() ?>&gt</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="table-responsive-sm p-5">
                        <table>
                            <thead style="border-bottom: 1px solid {{:invColor}};">
                                <tr>
                                    <th  style="color:{{:invColor}};" class="py-1"<strong>#<strong/></th>
                                    <th  style="color:{{:invColor}};" class="py-1 w-47 text-uppercase"><strong><?php echo __('messages.item') ?><strong/></th>
                                    <th  style="color:{{:invColor}};" class="py-1 text-uppercase"><strong><?php echo __('messages.invoice.qty') ?></strong></th>
                                    <th  style="color:{{:invColor}};" class="py-1 text-center text-uppercase text-nowrap"><strong><?php echo __('messages.product.unit_price') ?></strong></th>
                                    <th  style="color:{{:invColor}};" class="py-1 text-center text-uppercase text-nowrap"><strong><?php echo __('messages.invoice.tax') . '(in %)' ?></strong></th>
                                    <th  style="color:{{:invColor}};" class="py-1 text-end text-uppercase text-nowrap"><strong><?php echo __('messages.invoice.amount') ?></strong></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="py-1"><span>1</span></td>
                                    <td class="py-1 w-47"> <p class="fw-bold mb-0"><?php echo __('messages.item') ?> 1</p><?php echo __('messages.Description') ?></td>
                                    <td class="py-1">1</td>
                                    <td class="py-1 text-center text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                    <td class="py-1 text-center">N/A</td>
                                    <td class="py-1 text-end text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                </tr>
                                <tr>
                                    <td class="py-1"><span>2</span></td>
                                    <td class="py-1 w-47"> <p class="fw-bold mb-0"><?php echo __('messages.item') ?> 2</p><?php echo __('messages.Description') ?></td>
                                    <td class="py-1">1</td>
                                    <td class="py-1 text-center text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                    <td class="py-1 text-center">N/A</td>
                                    <td class="py-1 text-end text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                </tr>
                                <tr>
                                    <td class="py-1"><span>3</span></td>
                                    <td class="py-1 w-47"> <p class="fw-bold mb-0"><?php echo __('messages.item') ?> 3</p><?php echo __('messages.Description') ?></td>
                                    <td class="py-1">1</td>
                                    <td class="py-1 text-center text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                    <td class="py-1 text-center">N/A</td>
                                    <td class="py-1 text-end text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class="ms-auto m-5 mt-0 "  style="width:47%; border-top: 1px solid {{:invColor}};">
                        <tbody>
                            <tr>
                                <td class="py-1">
                                    <strong><?php echo __('messages.invoice.amount') ?></strong>
                                </td>
                                <td class="text-end py-1 text-nowrap">
                                    <?php echo getCurrencyAmount(300, true) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1">
                                    <strong><?php echo __('messages.invoice.discount') ?></strong>
                                </td>
                                <td class="text-end py-1 text-nowrap">
                                    <?php echo getCurrencyAmount(50, true) ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold py-1">
                                    <strong><?php echo __('messages.invoice.tax') ?></strong>
                                </td>
                                <td class="text-end py-1">
                                    N/A
                                </td>
                            </tr>
                        </tbody>
                        <tfoot style="border-top: 1px solid {{:invColor}};">
                            <tr>
                                <td class="pt-2">
                                    <strong><?php echo __('messages.invoice.total') ?></strong>
                                </td>
                                <td class="text-end pt-2 text-nowrap">
                                    <strong><?php echo getCurrencyAmount(250, true) ?></strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="p-5">
                        <div class="mb-8">
                            <h4 class="d-fancy-title mb5"><?php echo __('messages.client.notes') ?>:</h4>
                            <p class="font-color-gray" style="font-size: 13px;">
                            Paypal , Stripe & manual payment method accept. Net 10 – Payment due in 10 days from invoice date. Net 30 – Payment due in 30 days from invoice date.</p>
                        </div>
                        <div class="mb-8">
                            <h4 class="d-fancy-title mb5"><?php echo __('messages.invoice.terms') ?>:</h4>
                            <p class="font-color-gray"  style="font-size: 13px;">
                                Invoice payment Total ; 1% 10 Net 30, 1% discount if payment received within 10 days otherwise payment 30 days after invoice date.
                            </p>
                        </div>
                        <div>
                            <h5 class="d-fancy-title mb5"><b><?php echo __('messages.setting.regards') ?>:</b></h5>
                            <p class="font-color-gray" style="color:{{:invColor}} !important;">
                            <b>{{:companyName}}</b> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script id="rioTemplate" type="type/x-jsrender"><strong>
        <div class="preview-main client-preview">
            <div class="d" id="boxes">
                <table class="mb-8"  style="width: 100%;">
                    <tr>
                        <td style="vertical-align:top; width:30%;">
                            <img src="<?php echo getLogoUrl() ?>"class="img-logo" alt="logo">
                        </td>
                        <td style="width:30%;">
                            <p class="p-text mb-0"><?php echo __('messages.invoice.invoice_id') ?>: <strong>#9CQ5X7</strong></p>
                            <p class="p-text mb-0"><?php echo __('messages.invoice.invoice_date') ?>: <strong>2022-01-01 </strong></p>
                            <p class="p-text mb-0"><?php echo __('messages.invoice.due_date') ?>: <strong>2022-01-02</strong></p>
                        </td>
                        <td class="in-w-4" style="background-color: {{:invColor}};">
                            <h1 class="fancy-title tu text-center mb-auto p-3" style="color:white;  font-size: 34px"><?php echo __('messages.common.invoice') ?></h1>
                        </td>
                    </tr>
                </table>
                <table style="width:75%;" class="mb-8">
                    <tr>
                    <td class="w-50">
                            <p class="fs-6 mb-2"><strong><?php echo __('messages.common.to') ?>:</strong></p>
                            <p class=" m-0 font-color-gray fs-6"><?php echo __('messages.common.name')  ?>: <span class="text-dark fw-bold">&lt<?php echo __('messages.invoice.client_name')  ?>&gt</span></p>
                            <p class=" m-0 font-color-gray fs-6"><?php echo __('messages.common.email')  ?>: <span class="text-dark fw-bold">&lt<?php echo __('messages.invoice.client_email')  ?>&gt</span></p>
                            <p class=" m-0  font-color-gray fs-6"><?php echo __('messages.common.address')  ?>: <span class="text-dark fw-bold">&lt<?php echo __('messages.client_address')  ?>&gt</span></p>
                            <p class=" m-0  font-color-gray fs-6"><?php echo getVatNoLabel() ?>: <span class="text-dark fw-bold">&lt<?php echo getVatNoLabel() ?>&gt</span></p>
                        </td>
                        <td class="w-50">
                            <p class="fs-6 mb-2"><strong>From:</strong></p>
                            <p class=" m-0 font-color-gray fs-6"><?php echo __('messages.common.name')  ?>: <span class="text-dark fw-bold">{{:companyName}}</span></p>
                            <p class=" m-0 font-color-gray fs-6"><?php echo __('messages.common.address')  ?>: <span class="text-dark fw-bold">{{:companyAddress}}</span></p>
                            <p class=" m-0 font-color-gray fs-6"><?php echo __('messages.user.phone')  ?>: <span class="text-dark fw-bold">{{:companyPhone}}</span></p>
                            <p class=" m-0 font-color-gray fs-6"><?php echo getVatNoLabel() ?>: <span class="text-dark fw-bold">{{:gstNo}}</span></p>
                        </td>
                    </tr>
                </table>
                <div class="table-responsive-sm table-striped">
                    <table>
                        <thead style="background-color: {{:invColor}};">
                            <tr>
                                <th class="px-2 py-1 text-white text-center fw-bold"><strong>#</strong></th>
                                <th class="px-2 py-1 text-white in-w-2 fw-bold text-uppercase"><strong><?php echo __('messages.item') ?></strong></th>
                                <th class="px-2 py-1 text-white text-center fw-bold text-uppercase text-nowrap"><strong><?php echo __('messages.invoice.qty') ?></strong></th>
                                <th class="px-2 py-1 text-white text-center fw-bold text-uppercase text-nowrap"><strong><?php echo __('messages.product.unit_price') ?></strong></th>
                                <th class="px-2 py-1 text-white text-center fw-bold text-uppercase text-nowrap"><strong><?php echo __('messages.invoice.tax') . '(in %)' ?></strong></th>
                                <th class="px-2 py-1 text-white text-end fw-bold text-uppercase text-nowrap"><strong><?php echo __('messages.invoice.amount') ?></strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b-gray">
                                <td class="p-2 text-center bg-gray fw-bold">1</td>
                                <td class="p-2 in-w-2"> <p class="fw-bold mb-0"><?php echo __('messages.item') ?> 1</p><?php echo __('messages.Description') ?></td>
                                <td class="p-2 text-center fw-bold">1</td>
                                <td class="p-2 text-center bg-gray fw-bold text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                <td class="p-2 text-center fw-bold">N/A</td>
                                <td class="p-2 text-end bg-gray fw-bold text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                            </tr>
                            <tr class="border-b-gray">
                                <td class="p-2 text-center bg-gray fw-bold">2</td>
                                <td class="p-2 in-w-2"> <p class="fw-bold mb-0"><?php echo __('messages.item') ?> 2</p><?php echo __('messages.Description') ?></td>
                                <td class="p-2 text-center fw-bold">1</td>
                                <td class="p-2 text-center bg-gray fw-bold text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                <td class="p-2 text-center fw-bold">N/A</td>
                                <td class="p-2 text-end bg-gray fw-bold text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                            </tr>
                            <tr class="border-b-gray">
                                <td class="p-2 text-center bg-gray fw-bold">3</td>
                                <td class="p-2 in-w-2"> <p class="fw-bold mb-0"><?php echo __('messages.item') ?> 3</p><?php echo __('messages.Description') ?></td>
                                <td class="p-2 text-center fw-bold">1</td>
                                <td class="p-2 text-center bg-gray fw-bold text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                <td class="p-2 text-center fw-bold">N/A</td>
                                <td class="p-2 text-end bg-gray fw-bold text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="p-2 text-center fw-bold text-nowrap"><?php echo __('messages.invoice.amount') ?></td>
                                <td class="p-2 text-end bg-gray fw-bold text-nowrap"><?php echo getCurrencyAmount(300, true) ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="p-2 text-center fw-bold text-nowrap"><?php echo __('messages.invoice.discount') ?></td>
                                <td class="p-2 text-end bg-gray fw-bold text-nowrap"><?php echo getCurrencyAmount(50, true) ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="p-2 text-center fw-bold text-nowrap"><?php echo __('messages.invoice.tax') ?></td>
                                <td class="p-2 text-end bg-gray fw-bold text-nowrap">N/A</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="p-2 text-center fw-bold text-nowrap"><strong><?php echo __('messages.invoice.total') ?></strong></td>
                                <td class="p-2 text-end text-white fw-bold text-nowrap" style="background-color: {{:invColor}};"><?php echo getCurrencyAmount(250, true) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="position-relative" style="top:-50px;">
                    <p class="m-0 fs-6" style="color:{{:invColor}};"><b><?php echo __('messages.payment_qr_codes.payment_qr_code') ?></b></p>
                    <img class="mt-2" src="<?php echo asset('images/qrcode.png') ?>" height="100" width="100">
                </div>
                <div class="mb-8">
                    <h4 class="d-fancy-title mb5"><?php echo __('messages.client.notes') ?>:</h4>
                    <p class="font-color-gray">
                        Paypal , Stripe & manual payment method accept. Net 10 – Payment due in 10 days from invoice date. Net 30 – Payment due in 30 days from invoice date.
                    </p>
                </div>
                <table>
                    <tr>
                        <td class="w-75">
                            <div class="mb-8">
                                <h4 class="d-fancy-title mb5"><?php echo __('messages.invoice.terms') ?>:</h4>
                                <p class="font-color-gray">
                                    Invoice payment Total ; 1% 10 Net 30, 1% discount if payment received within 10 days otherwise payment 30 days after invoice date.
                                </p>
                            </div>
                        </td>
                        <td class="w-25 text-end">
                            <div>
                                <h4 class="d-fancy-title mb5"  style="color:{{:invColor}}"><?php echo __('messages.setting.regards') ?>:</h4>
                                <p class="font-color-gray"><b>{{:companyName}} </b></p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </script>

    <script id="londonTemplate" type="type/x-jsrender">
        <div class="preview-main client-preview">
        <div class="d" id="boxes">
            <div class="d-inner">
                <div class="header-section pt-10 mb-10" style="background-color: {{:invColor}};">
                    <table>
                        <tr>
                            <td class="bg-gray-100"  >
                            <div class="px-sm-3 px-2">
                            <img src="<?php echo getLogoUrl() ?>" class="img-logo" alt="logo">
                            </div>
                            </td>
                            <td class=" invoice-text"  style="width:40%;">
                                <div class="text-end">
                                <h1 class="m-0 p-sm-3 p-2"><?php echo __('messages.common.invoice') ?></h1>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-white text-end px-sm-3 px-2 py-2" style="font-size:12px;"><strong>#AB2324</strong></td>
                        </tr>
                    </table>
                </div>
                <table class="mb-8">
                    <tbody>
                        <tr style="vertical-align:top;">
                        <td width="43.33%;">
                        <p class="fs-6 mb-2"><strong><?php echo __('messages.common.from') ?></strong></p>
                        <p class=" m-0 font-color-gray fs-6"><strong><?php echo __('messages.common.name') ?>: </strong>{{:companyName}}</p>
                            <p class=" m-0 font-color-gray fw-bold fs-6"><strong><?php echo __('messages.common.address')  ?>: </strong>{{:companyAddress}}</p>
                            <p class=" m-0 font-color-gray  fw-bold fs-6"><strong><?php echo __('messages.user.phone')  ?>: </strong> {{:companyPhone}}</p>
                            <p class=" m-0 font-color-gray fs-6"><strong><?php echo getVatNoLabel() ?>: </strong> {{:gstNo}}</p>
                        </td>
                        <td width="23.33%;">
                            <p class="fs-6 mb-2"><strong><?php echo __('messages.common.to') ?></strong></p>
                            <p class=" m-0 font-color-gray fs-6"><strong><?php echo __('messages.common.name')  ?>: </strong>&lt<?php echo __('messages.invoice.client_name')  ?>&gt</p>
                            <p class=" m-0 font-color-gray fs-6"><strong><?php echo __('messages.common.email')  ?>: </strong>&lt<?php echo __('messages.invoice.client_email')  ?>&gt</p>
                            <p class=" m-0  font-color-gray fs-6"><strong><?php echo __('messages.common.address')  ?>: </strong> &lt<?php echo __('messages.client_address')  ?>&gt</p>
                            <p class=" m-0  font-color-gray fs-6"><strong><?php echo getVatNoLabel() ?>: </strong> &lt<?php echo getVatNoLabel() ?>&gt</p>
                        </td>
                        <td width="33.33%;" class="text-end">
                            <p class="mb-2 font-color-gray fs-6"><strong><?php echo __('messages.invoice.invoice_date') ?>: </strong>2022-01-01</p>
                            <p class="  font-color-gray fs-6"><strong><?php echo __('messages.invoice.due_date') ?>: </strong>2022-01-02</p>
                            <img class="mt-4" src="<?php echo asset('images/qrcode.png') ?>" height="100" width="100">
                        </td>
                        </tr>
                    </tbody>
                </table>
                <div class="w-100 overflow-auto">
                <table class="border-b-gray">
                        <thead class="bg-gray-100  text-dark">
                            <tr>
                                <th class="p-2"><strong>#</strong></th>
                                <th class="p-2 in-w-2 text-uppercase"><strong><?php echo __('messages.item') ?></strong></th>
                                <th class="p-2 text-center text-uppercase"><strong><?php echo __('messages.invoice.qty') ?></strong></th>
                                <th class="p-2 text-center text-nowrap text-uppercase"><strong><?php echo __('messages.product.unit_price') ?></strong></th>
                                <th class="p-2 text-center text-nowrap text-uppercase"><strong><?php echo __('messages.invoice.tax') . '(in %)' ?></strong></th>
                                <th class="p-2 text-end text-uppercase"><strong><?php echo __('messages.invoice.amount') ?></strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-2"><span>1</span></td>
                                <td class="p-2 in-w-2"> <p class="fw-bold mb-0"><?php echo __('messages.item') ?> 1</p><?php echo __('messages.Description') ?></td>
                                <td class="p-2 text-center">1</td>
                                <td class="p-2 text-center"> <?php echo getCurrencyAmount(100, true) ?></td>
                                <td class="p-2 text-center">N/A</td>
                                <td class="p-2 text-end"><?php echo getCurrencyAmount(100, true) ?></td>
                            </tr>
                            <tr>
                            <td class="p-2"><span>2</span></td>
                                <td class="p-2 in-w-2"> <p class="fw-bold mb-0"><?php echo __('messages.item') ?> 2</p><?php echo __('messages.Description') ?></td>
                                <td class="p-2 text-center">1</td>
                                <td class="p-2 text-center"> <?php echo getCurrencyAmount(100, true) ?></td>
                                <td class="p-2 text-center">N/A</td>
                                <td class="p-2 text-end"><?php echo getCurrencyAmount(100, true) ?></td>
                            </tr>
                            <tr>
                            <td class="p-2"><span>3</span></td>
                                <td class="p-2 in-w-2"> <p class="fw-bold mb-0"><?php echo __('messages.item') ?> 3</p><?php echo __('messages.Description') ?></td>
                                <td class="p-2 text-center">1</td>
                                <td class="p-2 text-center"><?php echo getCurrencyAmount(100, true) ?></td>
                                <td class="p-2 text-center">N/A</td>
                                <td class="p-2 text-end"><?php echo getCurrencyAmount(100, true) ?></td>
                            </tr>
                        </tbody>
                </table>
                </div>
                <table class="ms-auto mb-8" style="width:40%; ">
                    <tbody>
                        <tr>
                            <td class="py-1 px-2 text-nowrap">
                                <strong><?php echo __('messages.invoice.amount') ?></strong>
                            </td>
                            <td class="text-nowrap text-end font-color-gray py-1 px-2 fw-bold">
                                <?php echo getCurrencyAmount(300, true) ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1 px-2 text-nowrap">
                                <strong><?php echo __('messages.invoice.discount') ?></strong>
                            </td>
                            <td class="text-nowrap text-end font-color-gray py-1 px-2 fw-bold">
                                <?php echo getCurrencyAmount(50, true) ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold py-1 px-2 text-nowrap">
                                <strong><?php echo __('messages.invoice.tax') ?></strong>
                            </td>
                            <td class="text-end py-1 px-2 fw-bold">
                                N/A
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="text-white" style="background-color: {{:invColor}};">
                        <tr>
                            <td class="p-2 text-nowrap">
                                <strong> <?php echo __('messages.invoice.total') ?></strong>
                            </td>
                            <td class="text-end p-2 text-nowrap">
                                <strong> <?php echo getCurrencyAmount(250, true) ?></strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <div class="mb-8">
                    <h4 class="d-fancy-title mb5"><?php echo __('messages.client.notes') ?>:</h4>
                    <p class="font-color-gray"><span class="me-1"> <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/1000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2 0C0.895431 0 0 0.89543 0 2V8C0 9.10457 0.89543 10 2 10H8C9.10457 10 10 9.10457 10 8V2C10 0.895431 9.10457 0 8 0H2ZM4.72221 2.95508C4.72221 2.7825 4.58145 2.64014 4.41071 2.66555C3.33092 2.82592 2.5 3.80797 2.5 4.99549V7.01758C2.5 7.19016 2.63992 7.33008 2.8125 7.33008H4.40971C4.58229 7.33008 4.72221 7.19016 4.72221 7.01758V5.6021C4.72221 5.42952 4.58229 5.2896 4.40971 5.2896H3.61115V4.95345C3.61115 4.41687 3.95035 3.96422 4.41422 3.82285C4.57924 3.77249 4.72221 3.63715 4.72221 3.4645V2.95508ZM7.5 2.95508C7.5 2.7825 7.35924 2.64014 7.18849 2.66555C6.1087 2.82592 5.27779 3.80797 5.27779 4.99549V7.01758C5.27779 7.19016 5.41771 7.33008 5.59029 7.33008H7.1875C7.36008 7.33008 7.5 7.19016 7.5 7.01758V5.6021C7.5 5.42952 7.36008 5.2896 7.1875 5.2896H6.38885V4.95345C6.38885 4.41695 6.72813 3.96422 7.19193 3.82285C7.35703 3.77249 7.5 3.63715 7.5 3.4645V2.95508Z" fill="#8B919E"/>
                        </svg></span>Paypal , Stripe & manual payment method accept. Net 10 – Payment due in 10 days from invoice date. Net 30 – Payment due in 30 days from invoice date.
                    </p>
                </div>
                <table>
                    <tr>
                        <td class="w-75">
                            <div class="mb-8">
                                <h4 class="d-fancy-title mb5"><?php echo __('messages.invoice.terms') ?>:</h4>
                                <p class="font-color-gray">
                                    Invoice payment Total ; 1% 10 Net 30, 1% discount if payment received within 10 days otherwise payment 30 days after invoice date.
                                </p>
                            </div>
                        </td>
                        <td class="w-25 text-end">
                            <div>
                                <h4 class="d-fancy-title mb5"><?php echo __('messages.setting.regards') ?>:</h4>
                                <p class="fw-bold text-purple" style="color:{{:invColor}}"><b>{{:companyName}}</b> </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    </script>

    <script id="istanbulTemplate" type="type/x-jsrender">
        <div class="preview-main client-preview istanbul-template">
            <div class="d" id="boxes">
                <div class="d-inner">
                    <div>
                        <div class="invoice-header">
                            <table class="overflow-hidden">
                                <tr>
                                    <td class="heading-text w-30 ps-sm-10  py-10 ps-5 pe-10">
                                        <div class="position-relative z-10">
                                            <h1 class="m-0 text-white pt-2" style=" font-size: 32px; font-weight:700; letter-spacing:2px"><?php echo __('messages.common.invoice') ?></h1>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="px-sm-10  text-end">
                                            <img src="<?php echo getLogoUrl() ?>" class="img-logo" alt="logo">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="px-sm-10">
                            <table class=" mt-5">
                                <tr>
                                    <td class="text-end">
                                        <p class="mb-1 font-gray-600 fs-6"><strong class="font-gray-900"><?php echo __('messages.invoice.invoice_id') . ':' ?> </strong>#9CP5X7</p>
                                        <p class="mb-1 font-gray-600 fs-6"><strong class="font-gray-900"><?php echo __('messages.invoice.invoice_date') . ':' ?> </strong>01/01/2024</p>
                                        <p class=" mb-1 font-gray-600 fs-6"><strong class="font-gray-900"><?php echo __('messages.invoice.due_date') . ':' ?> </strong>15/01/2024</p>
                                    </td>
                                </tr>
                            </table>
                            <div class="overflow-auto mt-5">
                                <table>
                                    <tbody>
                                        <tr style="vertical-align:top;">
                                            <td class="pe-3">
                                                <p class="fs-6 mb-2 font-gray-900"><b><?php echo __('messages.common.to').':' ?></b></p>
                                                <p class="mb-1 fw-bold fs-6"><strong class="font-gray-600"><?php echo __('messages.common.name').':' ?> </strong>&lt<?php echo __('messages.invoice.client_name')  ?>&gt</p>
                                                <p class="mb-1 fw-bold fs-6" style="white-space:nowrap;"><strong class="font-gray-600"><?php echo __('messages.common.email').':' ?> </strong>&lt<?php echo __('messages.invoice.client_email')  ?>&gt</p>
                                                <p class="mb-1 fw-bold fs-6"><strong class="font-gray-600"><?php echo __('messages.common.address').':' ?> </strong>&lt<?php echo __('messages.client_address')  ?>&gt</p>
                                                <p class="mb-1 fw-bold fs-6"><strong class="font-gray-600"><?php echo getVatNoLabel() ?>: </strong>&lt<?php echo getVatNoLabel() ?>&gt</p>
                                            </td>
                                            <td>
                                                <div style="margin-left: auto; width:200px">
                                                    <p class="fs-6 mb-2 font-gray-900"><b><?php echo __('messages.common.from').':' ?></b></p>
                                                    <p class="mb-1 fw-bold fs-6"><strong class="font-gray-600"><?php echo __('messages.common.name').':' ?> </strong>{{:companyName}}</p>
                                                    <p class=" mb-1 fs-6"><strong class="font-gray-600"><?php echo __('messages.common.address').':' ?> </strong>123 Big Road Name London, WA34 3AD, UK</p>
                                                    <p class=" mb-1 fs-6"><strong class="font-gray-600"><?php echo __('messages.user.phone') . ':' ?> </strong>1234567890</p>
                                                    <p class="mb-1 fw-bold fs-6"><strong class="font-gray-600"><?php echo getVatNoLabel() ?>: </strong>{{:gstNo}}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="overflow-auto mt-10">
                                <table class="invoice-table">
                                    <thead style="background-color: {{:invColor}};">
                                        <tr>
                                            <th class="p-10px"><b>#</b></th>
                                            <th class="p-10px in-w-2 text-nowrap"><b><?php echo __('messages.product.product') ?></b></th>
                                            <th class="p-10px text-center"><b><?php echo __('messages.invoice.qty') ?></b></th>
                                            <th class="p-10px text-center text-nowrap"><b><?php echo __('messages.product.unit_price') ?></b></th>
                                            <th class="p-10px text-center text-nowrap"><b><?php echo __('messages.invoice.tax') . '(in %)' ?></b></th>
                                            <th class="p-10px text-end text-nowrap"><b><?php echo __('messages.invoice.amount') ?></b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="vertical-align:top;">
                                            <td class="p-10px font-gray-900"><span>1</span></td>
                                            <td class="p-10px font-gray-600 in-w-2">
                                                <p class="fw-6 mb-0 font-gray-900">Item 1</p><?php echo __('messages.Description') ?>
                                            </td>
                                            <td class="p-10px font-gray-600 text-center">1</td>
                                            <td class="p-10px font-gray-600 text-center text-nowrap">$ 100.00</td>
                                            <td class="p-10px font-gray-600 text-center">N/A</td>
                                            <td class="p-10px font-gray-600 text-end text-nowrap">$ 100.00</td>
                                        </tr>
                                        <tr style="vertical-align:top;">
                                            <td class="p-10px font-gray-900"><span>2</span></td>
                                            <td class="p-10px font-gray-600 in-w-2">
                                                <p class="fw-6 mb-0 font-gray-900">Item 2</p><?php echo __('messages.Description') ?>
                                            </td>
                                            <td class="p-10px font-gray-600 text-center">1</td>
                                            <td class="p-10px font-gray-600 text-center text-nowrap">$ 100.00</td>
                                            <td class="p-10px font-gray-600 text-center">N/A</td>
                                            <td class="p-10px font-gray-600 text-end text-nowrap">$ 100.00</td>
                                        </tr>
                                        <tr style="vertical-align:top;">
                                            <td class="p-10px font-gray-900"><span>3</span></td>
                                            <td class="p-10px font-gray-600 in-w-2">
                                                <p class="fw-6 mb-0 font-gray-900">Item 3</p><?php echo __('messages.Description') ?>
                                            </td>
                                            <td class="p-10px font-gray-600 text-center">1</td>
                                            <td class="p-10px font-gray-600 text-center text-nowrap">$ 100.00</td>
                                            <td class="p-10px font-gray-600 text-center">N/A</td>
                                            <td class="p-10px font-gray-600 text-end text-nowrap">$ 100.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="my-10">
                                <table>
                                    <tr>
                                        <td style="width:60%;">
                                            <svg xmlns="http://www.w3.org/1000/svg" width="70" height="70" viewBox="0 0 70 70" fill="none">
                                                <path d="M0 0V3.33333V6.66667V10V13.3333V16.6667V20V23.3333H3.33333H6.66667H10H13.3333H16.6667H20H23.3333V20V16.6667V13.3333V10V6.66667V3.33333V0H20H16.6667H13.3333H10H6.66667H3.33333H0ZM26.6667 0V3.33333V6.66667H30V3.33333H33.3333V0H30H26.6667ZM33.3333 3.33333V6.66667H36.6667V3.33333H33.3333ZM36.6667 6.66667V10H40H43.3333V6.66667V3.33333V0H40V3.33333V6.66667H36.6667ZM36.6667 10H33.3333H30H26.6667V13.3333H30H33.3333V16.6667H30V20H33.3333V23.3333H36.6667V20H40V23.3333H36.6667V26.6667H33.3333V30H36.6667H40V33.3333H43.3333V30V26.6667V23.3333V20V16.6667H40V13.3333H36.6667V10ZM40 33.3333H36.6667V36.6667H33.3333V40V43.3333H36.6667V46.6667V50H33.3333H30V46.6667H33.3333V43.3333H30V40V36.6667H26.6667V33.3333H30V36.6667H33.3333V33.3333V30H30H26.6667V26.6667H23.3333H20H16.6667V30H13.3333V33.3333H10V30H13.3333V26.6667H10H6.66667V30H3.33333V33.3333V36.6667V40H6.66667V36.6667H10H13.3333H16.6667V33.3333H20V30H23.3333V33.3333H20V36.6667H23.3333V40H20V43.3333H23.3333H26.6667V46.6667V50V53.3333H30V56.6667H33.3333H36.6667H40V60H36.6667H33.3333H30V56.6667H26.6667V60V63.3333H30V66.6667H26.6667V70H30H33.3333V66.6667H36.6667V70H40H43.3333H46.6667H50V66.6667H53.3333V70H56.6667H60H63.3333V66.6667H60H56.6667V63.3333H53.3333V60H50V63.3333H46.6667H43.3333V66.6667H40V63.3333H43.3333V60V56.6667V53.3333H46.6667V50H43.3333H40V46.6667H43.3333V43.3333V40V36.6667H40V33.3333ZM50 60V56.6667H46.6667V60H50ZM56.6667 63.3333H60H63.3333V60H60H56.6667V63.3333ZM63.3333 60H66.6667V56.6667V53.3333V50V46.6667H63.3333H60H56.6667V43.3333H53.3333V46.6667H50V50V53.3333H53.3333V50H56.6667V53.3333V56.6667H60H63.3333V60ZM53.3333 43.3333V40H50H46.6667V43.3333H50H53.3333ZM56.6667 43.3333H60V40V36.6667V33.3333H63.3333V36.6667H66.6667V40H70V36.6667V33.3333H66.6667V30H70V26.6667H66.6667H63.3333V30H60V26.6667H56.6667V30H53.3333V33.3333H56.6667V36.6667V40V43.3333ZM53.3333 33.3333H50V36.6667H53.3333V33.3333ZM66.6667 40H63.3333V43.3333H66.6667V40ZM20 40V36.6667H16.6667V40H20ZM16.6667 40H13.3333H10H6.66667V43.3333H10H13.3333H16.6667V40ZM3.33333 40H0V43.3333H3.33333V40ZM3.33333 30V26.6667H0V30H3.33333ZM26.6667 26.6667H30V23.3333V20H26.6667V23.3333V26.6667ZM46.6667 0V3.33333V6.66667V10V13.3333V16.6667V20V23.3333H50H53.3333H56.6667H60H63.3333H66.6667H70V20V16.6667V13.3333V10V6.66667V3.33333V0H66.6667H63.3333H60H56.6667H53.3333H50H46.6667ZM3.33333 3.33333H6.66667H10H13.3333H16.6667H20V6.66667V10V13.3333V16.6667V20H16.6667H13.3333H10H6.66667H3.33333V16.6667V13.3333V10V6.66667V3.33333ZM50 3.33333H53.3333H56.6667H60H63.3333H66.6667V6.66667V10V13.3333V16.6667V20H63.3333H60H56.6667H53.3333H50V16.6667V13.3333V10V6.66667V3.33333ZM6.66667 6.66667V10V13.3333V16.6667H10H13.3333H16.6667V13.3333V10V6.66667H13.3333H10H6.66667ZM53.3333 6.66667V10V13.3333V16.6667H56.6667H60H63.3333V13.3333V10V6.66667H60H56.6667H53.3333ZM46.6667 26.6667V30H50V26.6667H46.6667ZM0 46.6667V50V53.3333V56.6667V60V63.3333V66.6667V70H3.33333H6.66667H10H13.3333H16.6667H20H23.3333V66.6667V63.3333V60V56.6667V53.3333V50V46.6667H20H16.6667H13.3333H10H6.66667H3.33333H0ZM3.33333 50H6.66667H10H13.3333H16.6667H20V53.3333V56.6667V60V63.3333V66.6667H16.6667H13.3333H10H6.66667H3.33333V63.3333V60V56.6667V53.3333V50ZM6.66667 53.3333V56.6667V60V63.3333H10H13.3333H16.6667V60V56.6667V53.3333H13.3333H10H6.66667ZM66.6667 63.3333V66.6667H70V63.3333H66.6667Z" style="fill:#1A1C21;" />
                                            </svg>
                                        </td>
                                        <td style="vertical-align:top;">
                                            <table class="w-100">
                                                <tbody>
                                                    <tr>
                                                        <td class="pb-2" style="color:{{:invColor}}">
                                                            <strong><?php echo __('messages.invoice.sub_total') ?></strong>
                                                        </td>
                                                        <td class="text-nowrap text-end font-gray-600 pb-2 fw-bold">
                                                            $ 300.00
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pb-2" style="color:{{:invColor}}">
                                                            <strong><?php echo __('messages.invoice.discount') ?></strong>
                                                        </td>
                                                        <td class="text-nowrap text-end font-gray-600 pb-2 fw-bold">
                                                            $ 50.00
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pb-2" style="color:{{:invColor}}">
                                                            <strong><?php echo __('messages.invoice.tax') ?></strong>
                                                        </td>
                                                        <td class="text-nowrap text-end font-gray-600 pb-2 fw-bold">
                                                            $ 0.00
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot class="border-top-gray">
                                                    <tr>
                                                        <td class="py-2" style="color:{{:invColor}}">
                                                            <strong>Total</strong>
                                                        </td>
                                                        <td class="text-nowrap text-end font-gray-600 py-2 fw-bold">
                                                            $ 250.00
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="mt-20">
                                <table>
                                    <tr>
                                        <td class="w-50">
                                            <div class="mb-5">
                                                <h6 class="font-gray-900 mb5 fw-6"><?php echo __('messages.client.notes') ?>:</h6>
                                                <p class="font-gray-600">Please pay within 15 days of receiving this invoice.
                                                </p>
                                            </div>
                                            <div>
                                                <h6 class="font-gray-900 mb5 fw-6"><?php echo __('messages.invoice.terms') ?>:</h6>
                                                <p class="font-gray-600 ">Invoice payment total ; 1% 10 Net 30, 1% discount if payment received within 10 days otherwise payment 30 days after invoice date.</p>
                                            </div>
                                        </td>
                                        <td class="w-25 text-end" style="vertical-align:bottom;">
                                            <div>
                                                <h6 class="mb5" style="color:{{:invColor}}"><?php echo __('messages.setting.regards') ?>:</h6>
                                                <p class="font-gray-900 "><b>{{:companyName}} </b></p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script id="mumbaiTemplate" type="text/x-jsrender">
        <div class="preview-main client-preview mumbai-template">
            <div class="d" id="boxes">
                <div class="d-inner">
                <div class="top-border" style="background-color: {{:invColor}};"></div>
                    <div style="background-color: {{:invColor}};">
                        <table class="pb-10  bg-white">
                            <tr>
                                <td class=" p-0 h-125px" style="width:66%; overflow:hidden;">
                                <div class="bg-white p-4 pt-10 h-125px" style=" border-top-right-radius:30px;">
                                <img src="<?php echo getLogoUrl() ?>" class="img-logo" alt="logo">
                                </div>
                                </td>
                                <td class="bg-white p-0 h-125px" style="width:33%;border-bottom-left-radius:30px; overflow:hidden;">
                                    <div class="text-end p-4 pt-10 h-125px" style="background-color: {{:invColor}};" >
                                        <h1 class="m-0 text-white pe-2" style=" font-size: 36px; font-weight:700; letter-spacing: 4px;"><?php echo __('messages.common.invoice') ?></h1>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    <div class="px-4 me-3 bg-white">
                    <div class="pt-6">
                            <table class="mb-10">
                                <tbody >
                                    <tr style="vertical-align:top;">
                                    <td width="43.33%">
                                            <p class="fs-6 mb-2 font-gray-900"><b><?php echo __('messages.common.to') ?>:</b></p>
                                            <p class="mb-1 text-gray-600 fs-6"><?php echo __('messages.common.name')  ?>:  <span class="font-gray-900">&lt<?php echo __('messages.invoice.client_name')  ?>&gt</span></p>
                                            <p class="mb-1 text-gray-600 fs-6"><?php echo __('messages.common.email')  ?>: <span class="font-gray-900">&lt<?php echo __('messages.invoice.client_email')  ?>&gt</span></p>
                                            <p class="mb-1  text-gray-600 fs-6"><?php echo __('messages.common.address')  ?>: <span class="font-gray-900">&lt<?php echo __('messages.client_address')  ?>&gt </span></p>
                                            <p class="mb-1  text-gray-600 fs-6"><?php echo getVatNoLabel() ?>: <span class="font-gray-900">&lt<?php echo getVatNoLabel() ?>&gt </span></p>
                                        </td>
                                        <td width="23.33%">
                                            <p class="fs-6 mb-2 font-gray-900"><b><?php echo __('messages.common.from') ?>:</b></p>
                                            <p class="mb-1 text-gray-600 fs-6"><?php echo __('messages.common.name') ?>: <span class="font-gray-900">{{:companyName}}</span></p>
                                            <p class="mb-1 text-gray-600 fw-bold fs-6"><?php echo __('messages.common.address')  ?>:  <span class="font-gray-900"> {{:companyAddress}}</span></p>
                                            <p class="mb-1 text-gray-600  fw-bold fs-6"><?php echo __('messages.user.phone')  ?>: <span class="font-gray-900"> {{:companyPhone}}</span></p>
                                            <p class="mb-1 text-gray-600 fs-6 text-nowrap"><?php echo getVatNoLabel() ?>: <span class="font-gray-900 text-nowrap">{{:gstNo}}</span></p>
                                        </td>
                                        <td width="33.33%;" class="text-end pt-7">
                                            <p class="mb-1 text-gray-600 fs-6"><strong class="font-gray-900"><?php echo __('messages.invoice.invoice_id') ?>: </strong><strong>#5CW2X7</strong></p>
                                            <p class="mb-1 text-gray-600 fs-6"><strong class="font-gray-900"><?php echo __('messages.invoice.invoice_date') ?>: </strong><strong>01-08-2023</strong></p>
                                            <p class="mb-1 text-gray-600 fs-6"><strong  class="font-gray-900"><?php echo __('messages.invoice.due_date') ?>: </strong><strong>15-08-2023 </strong></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                <div class="overflow-auto">
                    <table class="invoice-table w-100">
                            <thead style="background-color: {{:invColor}};">
                                <tr>
                                    <th class="p-2 text-uppercase"><b>#</b></th>
                                    <th class="p-2 in-w-2 text-uppercase"><b><?php echo __('messages.item') ?></b></th>
                                    <th class="p-2 text-center text-uppercase"><b><?php echo __('messages.invoice.qty') ?></b></th>
                                    <th class="p-2 text-center text-uppercase text-nowrap"><b><?php echo __('messages.product.unit_price') ?></b></th>
                                    <th class="p-2 text-center text-uppercase text-nowrap"><b><?php echo __('messages.invoice.tax') . '(in %)' ?></b></th>
                                    <th class="p-2 text-end text-uppercase text-nowrap"><b><?php echo __('messages.invoice.amount') ?></b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-2"><span>1</span></td>
                                    <td class="p-2 in-w-2"> <p class="fw-bold mb-0"><?php echo __('messages.item') ?> 1</p><?php echo __('messages.Description') ?></td>
                                    <td class="p-2 text-center">1</td>
                                    <td class="p-2 text-center text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                    <td class="p-2 text-center">N/A</td>
                                    <td class="p-2 text-end text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                </tr>
                                <tr>
                                    <td class="p-2"><span>2</span></td>
                                    <td class="p-2 in-w-2"> <p class="fw-bold mb-0"><?php echo __('messages.item') ?> 2</p><?php echo __('messages.Description') ?></td>
                                    <td class="p-2 text-center">1</td>
                                    <td class="p-2 text-center text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                    <td class="p-2 text-center">N/A</td>
                                    <td class="p-2 text-end text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                </tr>
                                <tr>
                                    <td class="p-2"><span>3</span></td>
                                    <td class="p-2 in-w-2"> <p class="fw-bold mb-0"><?php echo __('messages.item') ?> 3</p><?php echo __('messages.Description') ?></td>
                                    <td class="p-2 text-center">1</td>
                                    <td class="p-2 text-center text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                    <td class="p-2 text-center">N/A</td>
                                    <td class="p-2 text-end text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                        <div class="my-10">
                            <table >
                                <tr>
                                    <td style="vertical-align:bottom; width:60%;" >
                                    <img class="mt-4" src="<?php echo asset('images/qrcode.png') ?>" height="100" width="100">
                                    </td>
                                    <td  style="vertical-align:top; width:40%;">
                                        <table class="w-100">
                                            <tbody>
                                                <tr>
                                                    <td class="text-nowrap py-1 px-2">
                                                        <strong><?php echo __('messages.invoice.amount') ?></strong>
                                                    </td>
                                                    <td class="text-nowrap text-end font-gray-600 py-1 px-2 fw-bold">
                                                        <?php echo getCurrencyAmount(300, true) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-nowrap py-1 px-2">
                                                        <strong><?php echo __('messages.invoice.discount') ?></strong>
                                                    </td>
                                                    <td class="text-nowrap text-end font-gray-600 py-1 px-2 fw-bold">
                                                        <?php echo getCurrencyAmount(50, true) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-nowrap py-1 px-2">
                                                        <strong><?php echo __('messages.invoice.tax') ?></strong>
                                                    </td>
                                                    <td class="text-end font-gray-600 py-1 px-2 fw-bold">
                                                    0%
                                                    </td>
                                                </tr>

                                            </tbody>
                                            <tfoot class="total-amount" style="background-color: {{:invColor}};">
                                                <tr>
                                                    <td class="text-nowrap p-2">
                                                        <strong><?php echo __('messages.invoice.total') ?></strong>
                                                    </td>
                                                    <td class="text-nowrap text-end p-2">
                                                        <strong> <?php echo getCurrencyAmount(250, true) ?></strong>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="mt-20">
                        <div class="mb-5 pt-10">
                            <h6 class="font-gray-900 mb5"><b><?php echo __('messages.client.notes') ?>:</b></h6>
                            <p class="font-gray-600">Paypal , Stripe & manual payment method accept. Net 10 – Payment due in 10 days from invoice date. Net 30 – Payment due in 30 days from invoice date.
                            </p>
                        </div>
                        <table>
                            <tr>
                                <td class="w-50">
                                    <div>
                                        <h6 class="font-gray-900 mb5"><b><?php echo __('messages.invoice.terms') ?>:</b></h6>
                                        <p class="font-gray-600 mb-0">Invoice payment Total ; 1% 10 Net 30, 1% discount if payment received within 10 days otherwise payment 30 days after invoice date.</p>
                                    </div>
                                </td>
                                <td class="w-25 text-end">
                                    <div class="mb-10 pb-4">
                                        <h5 class="text-indigo mb5"  style="color:{{:invColor}}"><b><?php echo __('messages.setting.regards') ?>:</b></h5>
                                        <p class="fs-6"><b>{{:companyName}} </b></p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    </div>
                    <div>
                        <table class="bg-white">
                                <tr>
                                    <td class=" p-0 h-25" style="width:80%; overflow:hidden; ">
                                        <div class="bg-white p-4 pt-10 h-25" style=" border-bottom-right-radius:30px;">
                                        </div>
                                    </td>
                                    <td class="bg-white p-0 h-25" style="width:20%;  border-top-left-radius:35px; overflow:hidden; ">
                                        <div class="text-end  p-4 pt-10 h-25" style="background-color: {{:invColor}};">
                                        </div>
                                    </td>
                                </tr>
                        </table>
                    </div>
                    <div class="bottom-border" style="background-color: {{:invColor}};"></div>
                </div>
            </div>
        </div>
    </script>

    <script id="hongKongTemplate" type="text/x-jsrender">
        <div class="preview-main client-preview hongkong-template">
            <div class="d" id="boxes">
                <div class="d-inner">
                    <div class="position-relative px-sm-10 ">
                        <div class="bg-img" style="position:absolute; right:0; top:0;">
                            <img  src="<?php echo asset('images/hongkong-bg-img.png') ?>" />
                        </div>
                        <div class="invoice-header pt-10">
                            <table class="overflow-hidden">
                                <tr>
                                    <td>
                                        <div>
                                            <img src="<?php echo getLogoUrl(); ?>" class="img-logo" alt="logo">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td class="heading-text">
                                        <div class="text-end">
                                            <h1 class="m-0" style="font-size: 32px; font-weight:700; letter-spacing:2px;color: {{:invColor}};">
                                                <?php echo __('messages.common.invoice'); ?></h1>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="pt-6 overflow-auto">
                            <table>
                                <tbody>
                                    <tr style="vertical-align:top;">
                                        <td width="43.33%;" class="pe-3">
                                            <p class="mb-2 font-gray-900 fw-bold"><b><?php echo __('messages.common.to').':' ?></b></p>
                                            <p class="mb-1 text-gray-600 fw-bold" style="white-space:nowrap;"><?php echo __('messages.common.name').':' ?> <span class="font-gray-900">&lt<?php echo __('messages.invoice.client_name')  ?>&gt</span></p>
                                            <p class="mb-1 text-gray-600 fw-bold" style="white-space:nowrap;"><?php echo __('messages.common.email').':' ?> <span class="font-gray-900">&lt<?php echo __('messages.invoice.client_email')  ?>&gt</span></p>
                                            <p class="mb-1 text-gray-600 fw-bold"><?php echo __('messages.common.address').':' ?> <span class="font-gray-900">&lt<?php echo __('messages.client_address')  ?>&gt</span></p>
                                            <p class="mb-1 text-gray-600 fw-bold"><?php echo getVatNoLabel() ?>: <span class="font-gray-900">&lt<?php echo getVatNoLabel() ?>&gt </span></p>
                                        </td>
                                        <td width="23.33%;" class="pe-3">
                                            <p class=" mb-2 font-gray-900 fw-bold"><b><?php echo __('messages.common.from') ?>:</b></p>
                                            <p class="mb-1 text-gray-600 fw-bold" style="white-space:nowrap;"><?php echo __('messages.common.name').':' ?> <span class="font-gray-900">{{:companyName}}</span></p>
                                            <p class=" mb-1 text-gray-600 fw-bold"><?php echo __('messages.common.address').':' ?><span class="font-gray-900"> 123 Big Road Name London, WA34 3AD, UK </span></p>
                                            <p class=" mb-1 text-gray-600  fw-bold" style="white-space:nowrap;"><?php echo __('messages.user.phone').':' ?><span class="font-gray-900"> 1234567890 </span></p>
                                            <p class="mb-1 text-gray-600 fw-bold text-nowrap"><?php echo getVatNoLabel() ?>: <span class="font-gray-900">{{:gstNo}}</span></p>
                                        </td>
                                        <td width="33.33%;" class="text-end">
                                            <p class="mb-1 text-gray-600 fw-bold" style="white-space:nowrap;"><strong class="font-gray-900"><?php echo __('messages.invoice.invoice_id') ?>: </strong><strong>#2BK5Y8</strong></p>
                                            <p class="mb-1 text-gray-600 fw-bold" style="white-space:nowrap;"><strong class="font-gray-900"><?php echo __('messages.invoice.invoice_date') ?>: </strong><strong>01/02/2024</strong></p>
                                            <p class=" mb-1 text-gray-600 fw-bold" style="white-space:nowrap;"><strong class="font-gray-900"><?php echo __('messages.invoice.due_date') ?>: </strong><strong>15/20/2024</strong></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="overflow-auto mt-10">
                            <table class="invoice-table w-100">
                                <thead style="background-color: {{:invColor}};">
                                    <tr>
                                        <th class="p-10px fw-6"># </th>
                                        <th class="p-10px fw-6 in-w-2"><?php echo __('messages.product.product') ?></th>
                                        <th class="p-10px fw-6 text-center"><?php echo __('messages.invoice.qty') ?></th>
                                        <th class="p-10px fw-6 text-center text-nowrap"><?php echo __('messages.product.unit_price') ?></th>
                                        <th class="p-10px fw-6 text-center text-nowrap"><?php echo __('messages.invoice.tax') . '(in %)' ?></th>
                                        <th class="p-10px fw-6 text-end text-nowrap"><?php echo __('messages.invoice.amount') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="p-10px font-gray-900 fw-6"><span>1</span></td>
                                        <td class="p-10px font-gray-600 in-w-2">
                                            <p class="fw-6 mb-0 font-gray-900">Item 1</p><?php echo __('messages.Description') ?>
                                        </td>
                                        <td class="p-10px font-gray-600 text-center">1</td>
                                        <td class="p-10px font-gray-600 text-center text-nowrap">$ 100.00</td>
                                        <td class="p-10px font-gray-600 text-center">N/A</td>
                                        <td class="p-10px font-gray-600 text-end text-nowrap">$ 100.00</td>
                                    </tr>
                                    <tr>
                                        <td class="p-10px font-gray-900 fw-6"><span>2</span></td>
                                        <td class="p-10px font-gray-600 in-w-2">
                                            <p class="fw-6 mb-0 font-gray-900">Item 2</p><?php echo __('messages.Description') ?>
                                        </td>
                                        <td class="p-10px font-gray-600 text-center">1</td>
                                        <td class="p-10px font-gray-600 text-center text-nowrap">$ 100.00</td>
                                        <td class="p-10px font-gray-600 text-center">N/A</td>
                                        <td class="p-10px font-gray-600 text-end text-nowrap">$ 100.00</td>
                                    </tr>
                                    <tr>
                                        <td class="p-10px font-gray-900 fw-6"><span>3</span></td>
                                        <td class="p-10px font-gray-600 in-w-2">
                                            <p class="fw-6 mb-0 font-gray-900"> Item 3</p><?php echo __('messages.Description') ?>
                                        </td>
                                        <td class="p-10px font-gray-600 text-center">1</td>
                                        <td class="p-10px font-gray-600 text-center text-nowrap">$ 100.00</td>
                                        <td class="p-10px font-gray-600 text-center">N/A</td>
                                        <td class="p-10px font-gray-600 text-end text-nowrap">$ 100.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <div class="mt-10">
                        <table>
                            <tr>
                                <td style="vertical-align:bottom; width:60%;">
                                    <svg xmlns="http://www.w3.org/1000/svg" width="70" height="70" viewBox="0 0 70 70" fill="none">
                                        <path d="M0 0V3.33333V6.66667V10V13.3333V16.6667V20V23.3333H3.33333H6.66667H10H13.3333H16.6667H20H23.3333V20V16.6667V13.3333V10V6.66667V3.33333V0H20H16.6667H13.3333H10H6.66667H3.33333H0ZM26.6667 0V3.33333V6.66667H30V3.33333H33.3333V0H30H26.6667ZM33.3333 3.33333V6.66667H36.6667V3.33333H33.3333ZM36.6667 6.66667V10H40H43.3333V6.66667V3.33333V0H40V3.33333V6.66667H36.6667ZM36.6667 10H33.3333H30H26.6667V13.3333H30H33.3333V16.6667H30V20H33.3333V23.3333H36.6667V20H40V23.3333H36.6667V26.6667H33.3333V30H36.6667H40V33.3333H43.3333V30V26.6667V23.3333V20V16.6667H40V13.3333H36.6667V10ZM40 33.3333H36.6667V36.6667H33.3333V40V43.3333H36.6667V46.6667V50H33.3333H30V46.6667H33.3333V43.3333H30V40V36.6667H26.6667V33.3333H30V36.6667H33.3333V33.3333V30H30H26.6667V26.6667H23.3333H20H16.6667V30H13.3333V33.3333H10V30H13.3333V26.6667H10H6.66667V30H3.33333V33.3333V36.6667V40H6.66667V36.6667H10H13.3333H16.6667V33.3333H20V30H23.3333V33.3333H20V36.6667H23.3333V40H20V43.3333H23.3333H26.6667V46.6667V50V53.3333H30V56.6667H33.3333H36.6667H40V60H36.6667H33.3333H30V56.6667H26.6667V60V63.3333H30V66.6667H26.6667V70H30H33.3333V66.6667H36.6667V70H40H43.3333H46.6667H50V66.6667H53.3333V70H56.6667H60H63.3333V66.6667H60H56.6667V63.3333H53.3333V60H50V63.3333H46.6667H43.3333V66.6667H40V63.3333H43.3333V60V56.6667V53.3333H46.6667V50H43.3333H40V46.6667H43.3333V43.3333V40V36.6667H40V33.3333ZM50 60V56.6667H46.6667V60H50ZM56.6667 63.3333H60H63.3333V60H60H56.6667V63.3333ZM63.3333 60H66.6667V56.6667V53.3333V50V46.6667H63.3333H60H56.6667V43.3333H53.3333V46.6667H50V50V53.3333H53.3333V50H56.6667V53.3333V56.6667H60H63.3333V60ZM53.3333 43.3333V40H50H46.6667V43.3333H50H53.3333ZM56.6667 43.3333H60V40V36.6667V33.3333H63.3333V36.6667H66.6667V40H70V36.6667V33.3333H66.6667V30H70V26.6667H66.6667H63.3333V30H60V26.6667H56.6667V30H53.3333V33.3333H56.6667V36.6667V40V43.3333ZM53.3333 33.3333H50V36.6667H53.3333V33.3333ZM66.6667 40H63.3333V43.3333H66.6667V40ZM20 40V36.6667H16.6667V40H20ZM16.6667 40H13.3333H10H6.66667V43.3333H10H13.3333H16.6667V40ZM3.33333 40H0V43.3333H3.33333V40ZM3.33333 30V26.6667H0V30H3.33333ZM26.6667 26.6667H30V23.3333V20H26.6667V23.3333V26.6667ZM46.6667 0V3.33333V6.66667V10V13.3333V16.6667V20V23.3333H50H53.3333H56.6667H60H63.3333H66.6667H70V20V16.6667V13.3333V10V6.66667V3.33333V0H66.6667H63.3333H60H56.6667H53.3333H50H46.6667ZM3.33333 3.33333H6.66667H10H13.3333H16.6667H20V6.66667V10V13.3333V16.6667V20H16.6667H13.3333H10H6.66667H3.33333V16.6667V13.3333V10V6.66667V3.33333ZM50 3.33333H53.3333H56.6667H60H63.3333H66.6667V6.66667V10V13.3333V16.6667V20H63.3333H60H56.6667H53.3333H50V16.6667V13.3333V10V6.66667V3.33333ZM6.66667 6.66667V10V13.3333V16.6667H10H13.3333H16.6667V13.3333V10V6.66667H13.3333H10H6.66667ZM53.3333 6.66667V10V13.3333V16.6667H56.6667H60H63.3333V13.3333V10V6.66667H60H56.6667H53.3333ZM46.6667 26.6667V30H50V26.6667H46.6667ZM0 46.6667V50V53.3333V56.6667V60V63.3333V66.6667V70H3.33333H6.66667H10H13.3333H16.6667H20H23.3333V66.6667V63.3333V60V56.6667V53.3333V50V46.6667H20H16.6667H13.3333H10H6.66667H3.33333H0ZM3.33333 50H6.66667H10H13.3333H16.6667H20V53.3333V56.6667V60V63.3333V66.6667H16.6667H13.3333H10H6.66667H3.33333V63.3333V60V56.6667V53.3333V50ZM6.66667 53.3333V56.6667V60V63.3333H10H13.3333H16.6667V60V56.6667V53.3333H13.3333H10H6.66667ZM66.6667 63.3333V66.6667H70V63.3333H66.6667Z"  style="fill:#008FFF;"/>
                                    </svg>
                                </td>
                                <td style="vertical-align:top; width:40%;">
                                    <table class="w-100">
                                        <tbody>
                                            <tr>
                                                <td class="text-nowrap font-gray-900 pb-2 px-2 ">
                                                    <strong><?php echo __('messages.invoice.sub_total') ?></strong>
                                                </td>
                                                <td class="text-nowrap text-end font-gray-600 pb-2 px-2 fw-bold">
                                                $ 300.00
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap font-gray-900 pb-2 px-2 ">
                                                    <strong><?php echo __('messages.invoice.discount') ?></strong>
                                                </td>
                                                <td class="text-nowrap text-end font-gray-600 pb-2 px-2 fw-bold">
                                                $ 50.00
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap font-gray-900 pb-2 px-2">
                                                    <strong><?php echo __('messages.invoice.tax') ?></strong>
                                                </td>
                                                <td class="text-nowrap text-end font-gray-600 pb-2 px-2 fw-bold">
                                                $ 0.00
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap font-gray-900 pb-2 px-2">
                                                    <strong><?php echo __('messages.invoice.total') ?></strong>
                                                </td>
                                                <td class="text-end font-gray-900 pb-2 px-2 fw-bold">
                                                    $ 250.00
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="total-amount" style="background-color: {{:invColor}};">
                                            <tr>
                                                <td class="text-nowrap p-10px">
                                                    <strong><?php echo __('messages.admin_dashboard.total_due') ?></strong>
                                                </td>
                                                <td class="text-nowrap text-end p-10px">
                                                    <strong>$ 250.00</strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-20">
                        <table>
                            <tr>
                                <td class="w-50">
                                    <div class="mb-5 pt-10">
                                        <h6 class="font-gray-900 mb5"><b><?php echo __('messages.client.notes') ?>:</b></h6>
                                        <p class="font-gray-600">Paypal , Stripe & manual payment method accept. Net 10 – Payment due in 10 days from invoice date. Net 30 – Payment due in 30 days from invoice date.
                                        </p>
                                    </div>
                                    <div>
                                        <h6 class="font-gray-900 mb5"><b><?php echo __('messages.invoice.terms') ?>:</b></h6>
                                        <p class="font-gray-600 mb-0">Invoice payment Total ; 1% 10 Net 30, 1% discount if payment received within 10 days otherwise payment 30 days after invoice date.</p>
                                    </div>
                                </td>
                                <td class="w-25 text-end" style="vertical-align:bottom;">
                                    <div>
                                        <h6 class="mb5" style="color:{{:invColor}}"><b><?php echo __('messages.setting.regards') ?>:</b></h6>
                                        <p class="mb-0"><b>{{:companyName}} </b></p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script id="tokyoTemplate" type="text/x-jsrender">
        <div class="preview-main client-preview tokyo-template">
            <div class="d" id="boxes">
                    <div class="container-fluid">
                        <table class=" mb-12">
                            <tr>
                                <td>
                                <img src="<?php echo getLogoUrl() ?>" class="img-logo" alt="logo">
                                </td>
                                <td class="heading-text">
                                    <div class="text-end">
                                        <h1 class="m-0 " style="color:{{:invColor}}"><?php echo __('messages.common.invoice') ?></h1>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="w-100 overflow-auto">
                            <table class="my-10">
                                <tbody>
                                    <tr style="vertical-align:top;">
                                    <td width="43.33%;" >
                                            <p class="fs-6 mb-2 font-gray-900"><strong><?php echo __('messages.common.to') ?>:</strong></p>
                                            <p class=" mb-1 text-gray-600 fs-6"><?php echo __('messages.common.name')  ?>:  <span class="font-gray-900">&lt<?php echo __('messages.invoice.client_name')  ?>&gt </span></p>
                                            <p class=" mb-1 text-gray-600 fs-6"><?php echo __('messages.common.email')  ?>: <span class="font-gray-900"> &lt<?php echo __('messages.invoice.client_email')  ?>&gt</span></p>
                                            <p class=" mb-1  text-gray-600 fs-6"><?php echo __('messages.common.address')  ?>: <span class="font-gray-900">&lt<?php echo __('messages.client_address')  ?>&gt</span></p>
                                            <p class=" mb-1  text-gray-600 fs-6"><?php echo getVatNoLabel() ?>: <span class="font-gray-900">&lt<?php echo getVatNoLabel() ?>&gt</span></p>
                                        </td>
                                        <td width="23.33%;" >
                                            <p class="fs-6 mb-2 font-gray-900"><strong><?php echo __('messages.common.from') ?>:</strong></p>
                                            <p class="mb-1 text-gray-600 fs-6"><?php echo __('messages.common.name') ?>: <span class="font-gray-900">{{:companyName}}</span></p>
                                            <p class="mb-1 text-gray-600 fw-bold fs-6"><?php echo __('messages.common.address')  ?>: <span class="font-gray-900"> {{:companyAddress}}</span></p>
                                            <p class="mb-1 text-gray-600  fw-bold fs-6"><?php echo __('messages.user.phone')  ?>: <span class="font-gray-900"> {{:companyPhone}}</span></p>
                                            <p class="mb-1 text-gray-600 fs-6 text-nowrap"><?php echo getVatNoLabel() ?>: <span class="font-gray-900">{{:gstNo}}</span></p>
                                        </td>
                                        <td width="33.33%;" class="text-end pt-7">
                                            <p class="mb-1 text-gray-600 fs-6"><strong class="font-gray-900"><?php echo __('messages.invoice.invoice_id') ?>: </strong><strong>#3TS4U7</strong></p>
                                            <p class="mb-1 text-gray-600 fs-6"><strong class="font-gray-900"><?php echo __('messages.invoice.invoice_date') ?>: </strong><strong>01-08-2023</strong></p>
                                            <p class=" mb-1 text-gray-600 fs-6"><strong  class="font-gray-900"><?php echo __('messages.invoice.due_date') ?>: </strong><strong>15-08-2023 </strong></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <div class="w-100 overflow-auto">
                        <table class="invoice-table">
                            <thead style="background-color: {{:invColor}};">
                                <tr>
                                    <th class="p-2 text-center"><b>#</b></th>
                                    <th class="p-2 in-w-2"><b><?php echo __('messages.item') ?></b></th>
                                    <th class="p-2 text-center text-nowrap"><b><?php echo __('messages.invoice.qty') ?></b></th>
                                    <th class="p-2 text-center text-nowrap"><b><?php echo __('messages.product.unit_price') ?></b></th>
                                    <th class="p-2 text-center text-nowrap"><b><?php echo __('messages.invoice.tax') . '(in %)' ?></b></th>
                                    <th class="p-2 text-end text-nowrap"><b><?php echo __('messages.invoice.amount') ?></b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class=" text-center"><span>01</span></td>
                                    <td class=" "><?php echo __('messages.item') ?> 1<p class="mb-0 fw-normal"><?php echo __('messages.Description') ?></p></td>
                                    <td class=" text-center">1</td>
                                    <td class=" text-center text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                    <td class=" text-center">N/A</td>
                                    <td class=" text-end text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                </tr>
                                <tr>
                                    <td class=" text-center"><span>02</span></td>
                                    <td class=" "><?php echo __('messages.item') ?> 2<p class="mb-0 fw-normal"><?php echo __('messages.Description') ?></p></td>
                                    <td class=" text-center">1</td>
                                    <td class=" text-center text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                    <td class=" text-center">N/A</td>
                                    <td class=" text-end text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                </tr>
                                <tr>
                                    <td class=" text-center"><span>03</span></td>
                                    <td class=" "><?php echo __('messages.item') ?> 3<p class="mb-0 fw-normal"><?php echo __('messages.Description') ?></p></td>
                                    <td class=" text-center">1</td>
                                    <td class=" text-center text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                    <td class=" text-center">N/A</td>
                                    <td class=" text-end text-nowrap"><?php echo getCurrencyAmount(100, true) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                        <div class="my-10">
                            <table class="ms-auto mb-10" style="width:250px;">
                                <tr>
                                    <td>
                                        <table class="w-100">
                                            <tbody>
                                                <tr>
                                                    <td class="py-1 px-0 font-dark-gray">
                                                        <strong ><?php echo __('messages.invoice.amount') ?></strong>
                                                    </td>
                                                    <td class="text-end font-gray-600 py-1 px-0 fw-bold">
                                                        <?php echo getCurrencyAmount(300, true) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="py-1 px-0 font-dark-gray">
                                                        <strong ><?php echo __('messages.invoice.discount') ?></strong>
                                                    </td>
                                                    <td class="text-end font-gray-600 py-1 px-0 fw-bold">
                                                        <?php echo getCurrencyAmount(50, true) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="pt-1 pb-2 px-0 font-dark-gray">
                                                        <strong><?php echo __('messages.invoice.tax') ?></strong>
                                                    </td>
                                                    <td class="text-end font-gray-600 pt-1 pb-2 px-0 fw-bold">
                                                    $0.00
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot class="total-amount">
                                            <tr>
                                                    <td class="py-2 font-dark-gray">
                                                        <strong><?php echo __('messages.invoice.total') ?></strong>
                                                    </td>
                                                    <td class="text-end font-dark-gray py-2 fw-bold">
                                                        <?php echo getCurrencyAmount(250, true) ?>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <div style="vertical-align:bottom; width:60%;" >
                                <img src="<?php echo asset('images/qrcode.png') ?>" height="100" width="100">
                            </div>
                        </div>
                        <div class="mt-20">
                        <div class="mb-5 pt-10">
                            <h6 class="font-gray-900 mb5"><b><?php echo __('messages.client.notes'); ?>:</b></h6>
                            <p class="font-gray-600">Paypal , Stripe & manual payment method accept. Net 10 – Payment due in 10 days from invoice date. Net 30 – Payment due in 30 days from invoice date.
                            </p>
                        </div>
                        <table class="mb-3">
                            <tr>
                                <td class="w-50">
                                    <div>
                                        <h6 class="font-gray-900 mb5"><b><?php echo __('messages.invoice.terms'); ?>:</b></h6>
                                        <p class="font-gray-600 mb-0">Invoice payment Total ; 1% 10 Net 30, 1% discount if payment received within 10 days otherwise payment 30 days after invoice date. </p>
                                    </div>
                                </td>
                                <td class="w-25 text-end">
                                    <div>
                                        <h5 class="font-dark-gray mb5"><b><?php echo __('messages.setting.regards') ?>:</b></h5>
                                        <p class="fs-6" style="color:{{:invColor}}">{{:companyName}}</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
            </div>
        </div>
    </script>

    <script id="parisTemplate" type="text/x-jsrender">
        <div class="preview-main client-preview paris-template">
            <div class="d" id="boxes">
                <div class="d-inner bg-img">
                    <div>
                    <div class="position-relative">
                        <div class="bg-img" style="position:absolute; left:0; top:0; min-width:220px;">
                            <img src="<?php echo asset('images/paris-bg-img.png') ?>" />
                        </div>
                        <div style="z-index:2;" class="position-relative">
                        <table>
                            <tr>
                                <td class="pe-2 py-0 pt-5 ps-0">
                                    <div class="px-sm-10 ps-2  pb-5" style="min-width:120px;">
                                        <img src="<?php echo getLogoUrl(); ?>" class="img-logo" alt="logo">
                                    </div>
                                </td>
                                <td class="heading-text px-sm-10 pb-5 pe-2" style="vertical-align:bottom;">
                                    <div class="text-end">
                                        <h1 class="m-0" style="color:{{:invColor}}"><?php echo __('messages.common.invoice'); ?></h1>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="px-sm-10 px-2">
                            <table>
                                <tr>
                                    <td class="text-end">
                                        <p class="mb-1 font-gray-600"><strong class="font-gray-900"><?php echo __('messages.invoice.invoice_id') ?>: </strong>#7NA6L2</p>
                                        <p class="mb-1 font-gray-600"><strong class="font-gray-900"><?php echo __('messages.invoice.invoice_date') ?>: </strong>01/03/2024</p>
                                        <p class="mb-1 font-gray-600"><strong class="font-gray-900"><?php echo __('messages.invoice.due_date') ?>: </strong>15/03/2024</p>
                                    </td>
                                </tr>
                            </table>
                            <div class="overflow-auto">
                                <table class="mt-10">
                                    <tbody>
                                        <tr style="vertical-align:top;">
                                            <td width="43.33%" class="pe-3">
                                                <p class="mb-2" style="color:{{:invColor}}"><strong><?php echo __('messages.common.from') . ':' ?></strong></p>
                                                <p class="mb-1 font-black-900 fw-bold" style="white-space:nowrap;"><strong><?php echo __('messages.common.name') . ':' ?> </strong>{{:companyName}}</p>
                                                <p class=" mb-1 font-black-900" style="max-width:220px;"><strong><?php echo __('messages.common.address') . ':' ?> </strong> C-303, Atlanta Shopping Mall, Nr. Sudama Chowk, Mota Varachha, Surat - 394101, Gujarat, India.</p>
                                                <p class=" mb-1 font-black-900" style="white-space:nowrap;"><strong><?php echo __('messages.user.phone') . ':' ?> </strong> +91 70963 36561</p>
                                                <p class="mb-1 font-black-900 fw-bold" style="white-space:nowrap;"><strong><?php echo getVatNoLabel() ?>: </strong> {{:gstNo}}</p>
                                            </td>
                                            <td width="23.33%" class="pe-3">
                                                <p class="mb-2" style="white-space:nowrap;color:{{:invColor}}"><strong><?php echo __('messages.common.to') ?>:</strong></p>
                                                <p class=" mb-1 font-black-900 fw-bold" style="white-space:nowrap;"><strong><?php echo __('messages.common.name') . ':' ?> </strong>&lt<?php echo __('messages.invoice.client_name')  ?>&gt</p>
                                                <p class=" mb-1 font-black-900 fw-bold" style="white-space:nowrap;"><strong><?php echo __('messages.common.email') . ':' ?> </strong>&lt<?php echo __('messages.invoice.client_email')  ?>&gt</p>
                                                <p class=" mb-1 font-black-900 fw-bold" style="white-space:nowrap;"><strong><?php echo __('messages.common.address') . ':' ?> </strong>&lt<?php echo __('messages.client_address')  ?>&gt</p>
                                                <p class=" mb-1 font-black-900 fw-bold" style="white-space:nowrap;"><strong><?php echo getVatNoLabel() ?>: </strong>&lt<?php echo getVatNoLabel() ?>&gt</p>
                                            </td>
                                            <td width="33.33%" class="text-center">
                                                <p class="mb-2" style="color:{{:invColor}}"><strong><?php echo __('messages.common.scan_to_pay') . ':' ?></strong></p>
                                                <div>
                                                    <svg width="70" height="70" viewBox="0 0 75 75" fill="none" xmlns="http://www.w3.org/1000/svg">
                                                        <g clip-path="url(#clip0_874_1274)">
                                                            <path d="M0 0V3.57143V7.14286V10.7143V14.2857V17.8571V21.4286V25H3.57143H7.14286H10.7143H14.2857H17.8571H21.4286H25V21.4286V17.8571V14.2857V10.7143V7.14286V3.57143V0H21.4286H17.8571H14.2857H10.7143H7.14286H3.57143H0ZM28.5714 0V3.57143V7.14286H32.1429V3.57143H35.7143V0H32.1429H28.5714ZM35.7143 3.57143V7.14286H39.2857V3.57143H35.7143ZM39.2857 7.14286V10.7143H42.8571H46.4286V7.14286V3.57143V0H42.8571V3.57143V7.14286H39.2857ZM39.2857 10.7143H35.7143H32.1429H28.5714V14.2857H32.1429H35.7143V17.8571H32.1429V21.4286H35.7143V25H39.2857V21.4286H42.8571V25H39.2857V28.5714H35.7143V32.1429H39.2857H42.8571V35.7143H46.4286V32.1429V28.5714V25V21.4286V17.8571H42.8571V14.2857H39.2857V10.7143ZM42.8571 35.7143H39.2857V39.2857H35.7143V42.8571V46.4286H39.2857V50V53.5714H35.7143H32.1429V50H35.7143V46.4286H32.1429V42.8571V39.2857H28.5714V35.7143H32.1429V39.2857H35.7143V35.7143V32.1429H32.1429H28.5714V28.5714H25H21.4286H17.8571V32.1429H14.2857V35.7143H10.7143V32.1429H14.2857V28.5714H10.7143H7.14286V32.1429H3.57143V35.7143V39.2857V42.8571H7.14286V39.2857H10.7143H14.2857H17.8571V35.7143H21.4286V32.1429H25V35.7143H21.4286V39.2857H25V42.8571H21.4286V46.4286H25H28.5714V50V53.5714V57.1429H32.1429V60.7143H35.7143H39.2857H42.8571V64.2857H39.2857H35.7143H32.1429V60.7143H28.5714V64.2857V67.8571H32.1429V71.4286H28.5714V75H32.1429H35.7143V71.4286H39.2857V75H42.8571H46.4286H50H53.5714V71.4286H57.1429V75H60.7143H64.2857H67.8571V71.4286H64.2857H60.7143V67.8571H57.1429V64.2857H53.5714V67.8571H50H46.4286V71.4286H42.8571V67.8571H46.4286V64.2857V60.7143V57.1429H50V53.5714H46.4286H42.8571V50H46.4286V46.4286V42.8571V39.2857H42.8571V35.7143ZM53.5714 64.2857V60.7143H50V64.2857H53.5714ZM60.7143 67.8571H64.2857H67.8571V64.2857H64.2857H60.7143V67.8571ZM67.8571 64.2857H71.4286V60.7143V57.1429V53.5714V50H67.8571H64.2857H60.7143V46.4286H57.1429V50H53.5714V53.5714V57.1429H57.1429V53.5714H60.7143V57.1429V60.7143H64.2857H67.8571V64.2857ZM57.1429 46.4286V42.8571H53.5714H50V46.4286H53.5714H57.1429ZM60.7143 46.4286H64.2857V42.8571V39.2857V35.7143H67.8571V39.2857H71.4286V42.8571H75V39.2857V35.7143H71.4286V32.1429H75V28.5714H71.4286H67.8571V32.1429H64.2857V28.5714H60.7143V32.1429H57.1429V35.7143H60.7143V39.2857V42.8571V46.4286ZM57.1429 35.7143H53.5714V39.2857H57.1429V35.7143ZM71.4286 42.8571H67.8571V46.4286H71.4286V42.8571ZM21.4286 42.8571V39.2857H17.8571V42.8571H21.4286ZM17.8571 42.8571H14.2857H10.7143H7.14286V46.4286H10.7143H14.2857H17.8571V42.8571ZM3.57143 42.8571H0V46.4286H3.57143V42.8571ZM3.57143 32.1429V28.5714H0V32.1429H3.57143ZM28.5714 28.5714H32.1429V25V21.4286H28.5714V25V28.5714ZM50 0V3.57143V7.14286V10.7143V14.2857V17.8571V21.4286V25H53.5714H57.1429H60.7143H64.2857H67.8571H71.4286H75V21.4286V17.8571V14.2857V10.7143V7.14286V3.57143V0H71.4286H67.8571H64.2857H60.7143H57.1429H53.5714H50ZM3.57143 3.57143H7.14286H10.7143H14.2857H17.8571H21.4286V7.14286V10.7143V14.2857V17.8571V21.4286H17.8571H14.2857H10.7143H7.14286H3.57143V17.8571V14.2857V10.7143V7.14286V3.57143ZM53.5714 3.57143H57.1429H60.7143H64.2857H67.8571H71.4286V7.14286V10.7143V14.2857V17.8571V21.4286H67.8571H64.2857H60.7143H57.1429H53.5714V17.8571V14.2857V10.7143V7.14286V3.57143ZM7.14286 7.14286V10.7143V14.2857V17.8571H10.7143H14.2857H17.8571V14.2857V10.7143V7.14286H14.2857H10.7143H7.14286ZM57.1429 7.14286V10.7143V14.2857V17.8571H60.7143H64.2857H67.8571V14.2857V10.7143V7.14286H64.2857H60.7143H57.1429ZM50 28.5714V32.1429H53.5714V28.5714H50ZM0 50V53.5714V57.1429V60.7143V64.2857V67.8571V71.4286V75H3.57143H7.14286H10.7143H14.2857H17.8571H21.4286H25V71.4286V67.8571V64.2857V60.7143V57.1429V53.5714V50H21.4286H17.8571H14.2857H10.7143H7.14286H3.57143H0ZM3.57143 53.5714H7.14286H10.7143H14.2857H17.8571H21.4286V57.1429V60.7143V64.2857V67.8571V71.4286H17.8571H14.2857H10.7143H7.14286H3.57143V67.8571V64.2857V60.7143V57.1429V53.5714ZM7.14286 57.1429V60.7143V64.2857V67.8571H10.7143H14.2857H17.8571V64.2857V60.7143V57.1429H14.2857H10.7143H7.14286ZM71.4286 67.8571V71.4286H75V67.8571H71.4286Z" fill="#242424" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_874_1274">
                                                                <rect width="75" height="75" fill="#242424" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="overflow-auto w-100 mt-10">
                                <table class="invoice-table">
                                    <thead style="background-color:{{:invColor}}">
                                        <tr>
                                            <th class="p-10px"><b>#</b></th>
                                            <th class="p-10px in-w-2"><b><?php echo __('messages.product.product') ?></b></th>
                                            <th class="p-10px text-center"><b><?php echo __('messages.invoice.qty') ?></b></th>
                                            <th class="p-10px text-center text-nowrap"><b><?php echo __('messages.product.unit_price') ?></b></th>
                                            <th class="p-10px text-center text-nowrap"><b><?php echo __('messages.invoice.tax') . '(in %)' ?></b></th>
                                            <th class="p-10px text-end text-nowrap"><b><?php echo __('messages.invoice.amount') ?></b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="p-10px font-gray-600"><span>1</span></td>
                                            <td class="p-10px font-gray-600 in-w-2">
                                                <p class="fw-6 mb-0 font-black-900">Item 1</p><?php echo __('messages.Description') ?>
                                            </td>
                                            <td class="p-10px font-gray-600 text-center">1</td>
                                            <td class="p-10px font-gray-600 text-center tex-nowrap">$ 100.00</td>
                                            <td class="p-10px font-gray-600 text-center">N/A</td>
                                            <td class="p-10px font-gray-600 text-end text-nowrap">$ 100.00</td>
                                        </tr>
                                        <tr>
                                            <td class="p-10px font-gray-600"><span>2</span></td>
                                            <td class="p-10px font-gray-600 in-w-2">
                                                <p class="fw-6 mb-0 font-black-900">Item 2</p><?php echo __('messages.Description') ?>
                                            </td>
                                            <td class="p-10px font-gray-600 text-center">1</td>
                                            <td class="p-10px font-gray-600 text-center tex-nowrap">$ 100.00</td>
                                            <td class="p-10px font-gray-600 text-center">N/A</td>
                                            <td class="p-10px font-gray-600 text-end text-nowrap">$ 100.00</td>
                                        </tr>
                                        <tr>
                                            <td class="p-10px font-gray-600"><span>3</span></td>
                                            <td class="p-10px font-gray-600 in-w-2">
                                                <p class="fw-6 mb-0 font-black-900">Item 3</p><?php echo __('messages.Description') ?>
                                            </td>
                                            <td class="p-10px font-gray-600 text-center">1</td>
                                            <td class="p-10px font-gray-600 text-center tex-nowrap">$ 100.00</td>
                                            <td class="p-10px font-gray-600 text-center">N/A</td>
                                            <td class="p-10px font-gray-600 text-end text-nowrap">$ 100.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-10">
                                <table style="width:250px; margin-left:auto;">
                                    <tbody style="border-bottom:1px solid #cecece">
                                        <tr>
                                            <td class="pb-2" style="color:{{:invColor}}">
                                                <strong><?php echo __('messages.invoice.sub_total') ?></strong>
                                            </td>
                                            <td class="text-end font-gray-600 pb-2 fw-bold">
                                                $ 300.00
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pb-2" style="color:{{:invColor}}">
                                                <strong><?php echo __('messages.invoice.discount') ?></strong>
                                            </td>
                                            <td class="text-end font-gray-600 pb-2 fw-bold">
                                                $ 50.00
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pb-2" style="color:{{:invColor}}">
                                                <strong><?php echo __('messages.invoice.tax') ?></strong>
                                            </td>
                                            <td class="text-end font-gray-600 pb-2 fw-bold">
                                                $ 0.00
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="total-amount">
                                        <tr>
                                            <td class="py-2" style="color:{{:invColor}}">
                                                <strong><?php echo __('messages.invoice.total') ?></strong>
                                            </td>
                                            <td class="text-end py-2">
                                                $ 250.00
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <table class="mt-15 w-100">
                                <tr>
                                    <td>
                                        <div class="mb-5 mt-sm-0 mt-2">
                                            <h6 class="font-gray-900 mb5"><b><?php echo __('messages.client.notes'); ?>:</b></h6>
                                            <p class="font-gray-600">
                                                <span class="me-1">
                                                    <svg width="14" height="14" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/1000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2 0C0.895431 0 0 0.89543 0 2V8C0 9.10457 0.89543 10 2 10H8C9.10457 10 10 9.10457 10 8V2C10 0.895431 9.10457 0 8 0H2ZM4.72221 2.95508C4.72221 2.7825 4.58145 2.64014 4.41071 2.66555C3.33092 2.82592 2.5 3.80797 2.5 4.99549V7.01758C2.5 7.19016 2.63992 7.33008 2.8125 7.33008H4.40971C4.58229 7.33008 4.72221 7.19016 4.72221 7.01758V5.6021C4.72221 5.42952 4.58229 5.2896 4.40971 5.2896H3.61115V4.95345C3.61115 4.41687 3.95035 3.96422 4.41422 3.82285C4.57924 3.77249 4.72221 3.63715 4.72221 3.4645V2.95508ZM7.5 2.95508C7.5 2.7825 7.35924 2.64014 7.18849 2.66555C6.1087 2.82592 5.27779 3.80797 5.27779 4.99549V7.01758C5.27779 7.19016 5.41771 7.33008 5.59029 7.33008H7.1875C7.36008 7.33008 7.5 7.19016 7.5 7.01758V5.6021C7.5 5.42952 7.36008 5.2896 7.1875 5.2896H6.38885V4.95345C6.38885 4.41695 6.72813 3.96422 7.19193 3.82285C7.35703 3.77249 7.5 3.63715 7.5 3.4645V2.95508Z" fill="#8B919E"></path>
                                                    </svg>
                                                </span>
                                                Please pay within 15 days of receiving this invoice.
                                            </p>
                                        </div>
                                        <div>
                                            <h6 class="font-gray-900 mb5"><b><?php echo __('messages.invoice.terms'); ?>:</b></h6>
                                            <p class="font-gray-600 mb-0">Invoice payment total ; 1% 10 Net 30, 1% discount if payment received within 10 days otherwise payment 30 days after invoice date.
                                            </p>
                                        </div>
                                    </td>
                                    <td style="vertical-align:bottom; width:30%;" class="text-end">
                                        <div>
                                            <h6 class="font-dark-gray mb5 pt-3"><?php echo __('messages.setting.regards') ?>:</h6>
                                            <p class="fw-6 mb-0" style="color:{{:invColor}}">{{:companyName}}</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
</div>
</div>
                    </div>
                </div>
            </div>
        </div>
    </script>
