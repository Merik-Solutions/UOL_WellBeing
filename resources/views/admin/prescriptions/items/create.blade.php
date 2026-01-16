<div class="row">
    <div class="col-12">
        <div class="card-box">
            <h4 class="mt-0 header-title d-inline">{!! __("Items") !!}</h4>
            <div class="mt-0 header-title float-right  d-inline">

                <a class="btn btn-info text-white" onclick="AddItem()">
                    <i class="fas fa-plus"></i> {!! __("Add Item")!!}</a>
            </div>
            <div class="pt-4">


                <table id="prescription-item-table" class="table table-striped table-bordered  ">
                    <thead>
                    <tr>
                        <th>{!! __("Medicine") !!}</th>
                        <th>{!! __("Dose") !!}</th>
                        <th>{!! __("Description") !!}</th>
                        <th>{!! __('Actions') !!}</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($items as $item)
                        @component('admin.prescriptions.items._form',['item'=>$item,'iteration'=>$loop->iteration])
                        @endcomponent
                    @endforeach



                    {{--default row--}}
                    @component('admin.prescriptions.items._form',['item'=>new stdClass(),'iteration'=>0])
                    @endcomponent
                    {{--default row--}}


                    </tbody>
                </table>


            </div>

        </div>
    </div>
</div>
@push('scripts')
    <script>
        var default_item = $('#prescription-item-table >tbody >tr[data-item-key=0]').clone()[0].outerHTML;

        function AddItem() {
            var table_body = $('#prescription-item-table >tbody');
            var counter = table_body.children().length;
            var new_item = default_item.replace(/0/g, counter);
            table_body.append(new_item);
        }

        function DeleteItem(button) {
            Swal.fire({
                title: "{!! __('Are you sure?') !!}",
                text: "{!! __("You won't be able to revert this!") !!}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{!! __("Yes, delete it!") !!}',
                cancelButtonText: '{!! __("Cancel") !!}'
            }).then((result) => {
                if (result.value) {
                    var row = $(button).closest('tr');
                    row.remove();
                    Swal.fire(
                        "{!! __('Deleted!') !!}",
                        "{!! __('success') !!}"
                    )
                }
            });
        }

    </script>
@endpush
