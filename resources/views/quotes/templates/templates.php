<script id="quotesItemTemplate" type="text/x-jsrender">
<tr class="border-bottom border-bottom-dashed tax-tr">
    <td class="text-center item-number align-center">1</td>
    <td class="table__item-desc w-25">
        <select class="form-select productId product-quote  fw-bold" name="product_id[]" 'data-control' => 'select2' required>
            <option selected="selected" value="">Select Product or Enter free text</option>
            {{for products}}
                <option value="{{:key}}">{{:value}}</option>
            {{/for}}
        </select>
    </td>
    <td class="table__qty">
        <input class="form-control qty-quote" required="" name="quantity[]" type="number" min="1" oninput="validity.valid||(value=value.replace(/\D+/g, ''))">
    </td>
    <td>
        <input class="form-control price-input price-quote" required="" name="price[]" type="number" oninput="validity.valid||(value=value.replace(/[e\+\-]/gi,''))" min='0' step='.01' onKeyPress="if(this.value.length==8) return false;">
    </td>
    <td class="tbAmount text-left quote-item-total pt-8 text-nowrap" style="text-align:left">

    </td>
    <td class="text-end">
        <button type="button" title="Delete" class="btn btn-sm text-danger fs-3 btn-icon btn-active-color-danger delete-quote-item">
                  <i class="fa-solid fa-trash"></i>
        </button>
    </td>
</tr>



</script>
