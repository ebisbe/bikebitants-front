@extends('admin.admin')

@section('content')
    <div class="panel panel-flat">

        <table class="table table-bordered table-striped table-hover datatable-scroller">
            <thead>
            <tr>
                <th>Email</th>
                <th>Type</th>
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
                    {'data': 'email'}, {'data': 'type'}
                ],
                columnDefs: [
                    {
                        width: "23%",
                        targets: ['email', 'type']
                    }
                ],
                dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                ajax: '/lead/data-table',
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
                        targets: [],
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
