$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Accept-Language': document.documentElement.lang
    }
});

$(".datatable-buttons").DataTable(
    {
        responsive: false,
        //  lengthChange: !1,
        // paging: false,
        // order: [[ 0, 'DESC' ]],
        buttons: ["copy", "excel", "pdf"],
        //   keys: !0
    }
);
$(".dataTable_payment").DataTable(
    {
        responsive: false,
        // order: [[ 0, 'DESC' ]],
        buttons: ["copy", "excel", "pdf"],
        //   keys: !0
    }
);

$("a[data-toggle=\"tab\"]").on("shown.bs.tab", function (e) {
    var datatables = $($.fn.dataTable.tables(true));
    datatables.css('width', '100%');
    datatables.DataTable()
        .columns.adjust()
        // .responsive.recalc()
        .draw();
});

$(".select2").select2();

$('.datepicker').datepicker({
    autoclose: true,
    todayHighlight: true,
    format: 'yyyy-mm-dd',
});

$('.timepicker').timepicker({
    defaultTime: "",
    icons: {
        up: 'mdi mdi-chevron-up',
        down: 'mdi mdi-chevron-down'
    }
});


///select helpers

function getOptionsForSelect(select_name, route_name, data, res_key, method) {
    data = data || {};
    method = method || 'post';
    $.ajax({
        method: method,
        url: route(route_name),
        data: data,
        success: function (res) {

            var data = res.data[res_key];
            var selector = 'select[name="' + select_name + '"]';
            var placeholder = getPlaceholder(selector);
            var options = placeholder + getOptions(data);
            $(selector).html(options);
        }
    })
}


function getOptions(list) {
    var options = '';
    list.forEach(function (val) {

        var obj_string = JSON.stringify(val);
        options += '<option value="' + val.id + '" data-attrs=\'' + obj_string + ' \'>' + val.name + ' </option>'
    });

    return options;
}

function getPlaceholder(selector) {
    var select_options = $(selector).children('option');

    return (select_options.length != 0) ? '<option disabled selected value="">' + select_options[0].innerHTML + '</option>' : "";

}


//advance multiselect start
$('.multi-select').multiSelect({
    selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
    selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
    afterInit: function (ms) {
        var that = this,
            $selectableSearch = that.$selectableUl.prev(),
            $selectionSearch = that.$selectionUl.prev(),
            selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
            selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

        that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
            .on('keydown', function (e) {
                if (e.which === 40) {
                    that.$selectableUl.focus();
                    return false;
                }
            });

        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
            .on('keydown', function (e) {
                if (e.which == 40) {
                    that.$selectionUl.focus();
                    return false;
                }
            });
    },
    afterSelect: function () {
        this.qs1.cache();
        this.qs2.cache();
    },
    afterDeselect: function () {
        this.qs1.cache();
        this.qs2.cache();
    }
});


