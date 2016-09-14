@extends('admin.admin')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Products</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
            <a class="heading-elements-toggle"><i class="icon-menu"></i></a></div>

        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Featured</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>
                        <product-status
                                status_selected="{{ $product->status }}"
                                product_id="{{ $product->_id }}"
                                token="{{ csrf_token() }}"
                        ></product-status>
                    </td>
                    <td>
                        <product-featured
                                is_featured="{{ $product->featured }}"
                                product_id="{{ $product->_id }}"
                                token="{{ csrf_token() }}">

                        </product-featured>
                    </td>
                    <td>
                        <div class="btn-group position-right">
                            <button aria-expanded="false" type="button" class="btn btn-info btn-icon dropdown-toggle"
                                    data-toggle="dropdown"><i class="icon-menu7"></i><span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu">
                                <li><a href="{{ route('product.edit', ['_id' => $product->_id]) }}"><i
                                                class="icon-pencil7"></i>&nbsp;Edit</a></li>
                                <li>
                                    <form action="{{ route('product.destroy', ['_id' => $product->_id]) }}"
                                          method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" id="delete-task-{{ $product->id }}"
                                                class="btn btn-xs btn-link">
                                            <i class="fa fa-trash"></i>&nbsp;Delete
                                        </button>
                                    </form>
                                </li>
                                <li><a href="{{ route('product.duplicate', ['_id' => $product->_id]) }}"><i
                                                class="icon-copy4"></i>&nbsp;Duplicate</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <p>

            {{ $products->links() }}
        </p>
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
                    {'data': '_id'},
                    {
                        'data': 'name',
                        'render': function (data, type, full, meta) {
                            var view_btn = '<a href="/product/' + full._id + '">' + data + '</a>';
                            var edit_btn = '<a href="/product/' + full._id + '/edit" class="btn-xs btn-link"><i class="icon-pencil4"></i></a>';
                            var delete_btn = '{!! Form::open([
                                        'method'=>'DELETE',
                                        'url' => "/product/full_id" ,
                                        'style' => 'display:inline'
                                    ]) !!}{!! Form::button('<i class="icon-bin" alt="edit"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-link']) !!}{!! Form::close() !!}';
                            return view_btn + '&nbsp;' + edit_btn + '&nbsp;' + delete_btn.replace('full_id', full._id);
                        }
                    }, {'data': 'slug'}, {'data': 'status'}, {'data': 'introduction'}, {'data': 'description'}, {'data': 'meta_title'}, {'data': 'meta_description'}, {'data': 'meta_slug'}
                ],
                columnDefs: [
                    {
                        width: "100px",
                        targets: ['_id']
                    },
                    {
                        width: "23%",
                        targets: ['name', 'slug', 'status', 'introduction', 'description', 'meta_title', 'meta_description', 'meta_slug']
                    }
                ],
                dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                ajax: '/product/data-table',
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


            $('.datatable').DataTable({
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
                        targets: [-1, -2, -3, -4],
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
