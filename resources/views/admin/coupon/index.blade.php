@extends('layouts.admin')

@section('content')
    <div class="panel panel-flat">

        <table class="table table-bordered table-striped table-hover datatable-scroller">
            <thead>
            <tr>
                <th>Name</th>
                <th>Value</th>
                <th>Expiry Date</th>
                <th>Minimum Cart</th>
                <th>Maximum Cart</th>
                <th>Limit Usage By Coupon</th>
                <th>Limit Usage By User</th>
                <th>Single Use</th>
                <th>Emails</th>
            </tr>
            </thead>
        </table>
    </div>
    @push('footer.scripts')
            <!-- Theme JS files -->
    {!! Html::script('/assets/js/plugins/tables/datatables/datatables.min.js') !!}
    {!! Html::script('/assets/js/plugins/tables/datatables/extensions/scroller.min.js') !!}
    {!! Html::script('/assets/js/plugins/tables/datatables/extensions/buttons.min.js') !!}
    {!! Html::script('/assets/js/plugins/forms/selects/select2.min.js') !!}
            <!-- /Theme Js files -->
    <script type="application/javascript">
        $(function () {


            // Override defaults
            // ------------------------------

            // Datatable defaults
            $.extend($.fn.dataTable.defaults, {
                columns: [
                    {
                        'data': 'name',
                        'render': function (data, type, full, meta) {
                            var view_btn = '<a href="/coupon/' + full._id + '">' + data + '</a>';
                            var edit_btn = '<a href="/coupon/' + full._id + '/edit" class="btn-xs btn-link"><i class="icon-pencil4"></i></a>';
                            var delete_btn = '{!! Form::open([
                                        'method'=>'DELETE',
                                        'url' => "/coupon/full_id" ,
                                        'style' => 'display:inline'
                                    ]) !!}{!! Form::button('<i class="icon-bin" alt="edit"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-link']) !!}{!! Form::close() !!}';
                            return view_btn + '&nbsp;' + edit_btn + '&nbsp;' + delete_btn.replace('full_id', full._id);
                        }
                    }, {'data': 'value'}, {'data': 'expired_at'}, {'data': 'minimum_cart'}, {'data': 'maximum_cart'}, {'data': 'limit_usage_by_coupon'}, {'data': 'limit_usage_by_user'}, {'data': 'single_use'}, {'data': 'emails'}
                ],
                columnDefs: [
                    {
                        width: "23%",
                        targets: ['name', 'value', 'expired_at', 'minimum_cart', 'maximum_cart', 'limit_usage_by_coupon', 'limit_usage_by_user', 'single_use', 'emails']
                    }
                ],
                dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                ajax: '/coupon/data-table',
                deferRender: true,
                scrollY: "600px",
                scrollX: true,
                autoWidth: false,
                scrollCollapse: true,
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
                }
            });


            $('.datatable-scroller').DataTable({
                buttons: [
                    {
                        extend: 'colvis',
                        text: '<i class="icon-grid3"></i> <span class="caret"></span>',
                        className: 'btn bg-indigo-400 btn-icon',
                        postfixButtons: ['colvisRestore'],
                        collectionLayout: 'fixed two-column'
                    }
                ],
                stateSave: true,
                columnDefs: [
                    {
                        targets: [-1, -2, -3, -4, -5, -6],
                        visible: false
                    }
                ]
            });

            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: 'auto'
            });
        });
    </script>
    @endpush
@endsection
