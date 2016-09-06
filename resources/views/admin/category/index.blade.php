@extends('admin.admin')

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Category</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse" class=""></a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <p>Sort elements with drag & drop.</p>
            <div class="table-responsive">
                <table class="table table-bordered tree-table table-sm">
                    <thead>
                    <tr>
                        <th style="width: 46px;"></th>
                        <th style="width: 80px;">#</th>
                        <th>Items</th>
                        <th style="width: 80px;">Products</th>
                        <th style="width:100px;">Action buttons</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('footer.scripts')
    <script type="application/javascript">
        $(function () {


            $(".tree-table").fancytree({
                extensions: ["table", "dnd"],
                checkbox: true,
                table: {
                    indentation: 20,      // indent 20px per node level
                    nodeColumnIdx: 2,     // render the node title into the 2nd column
                    checkboxColumnIdx: 0  // render the checkboxes into the 1st column
                },
                source: {
                    url: "category/tree"
                },

                renderColumns: function (event, data) {
                    var node = data.node,
                            $tdList = $(node.tr).find(">td");

                    // (index #0 is rendered by fancytree by adding the checkbox)
                    $tdList.eq(1).text(node.getIndexHier()).addClass("alignRight");
                    // (index #2 is rendered by fancytree)
                    $tdList.eq(3).text(node.data.products);
                    $tdList.eq(4).addClass('text-center').html(node.data.actionButtons);

                    // Style checkboxes
                    $(".styled").uniform({radioClass: 'choice'});
                },
                dnd: {
                    autoExpandMS: 400,
                    focusOnClick: true,
                    preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
                    preventRecursiveMoves: true, // Prevent dropping nodes on own descendants
                    dragStart: function (node, data) {
                        return true;
                    },
                    dragEnter: function (node, data) {
                        return true;
                    },
                    dragDrop: function (node, data) {
                        // This function MUST be defined to enable dropping of items on the tree.
                        data.otherNode.moveTo(node, data.hitMode);
                        $.ajax({
                                    url: '{{ route('category.update-order') }}',
                                    data: {
                                        'hitMode': data.hitMode,
                                        'target': data.node.data._id,
                                        'dragged': data.otherNode.data._id,
                                        '_token': '{{ csrf_token() }}'
                                    },
                                    method: 'post'
                                })
                                .done(function () {
                                    console.log("success");
                                })
                                .fail(function () {
                                    console.log("error");
                                })
                                .always(function () {
                                    console.log("complete");
                                });
                    }
                }
            });
        });
    </script>
    @endpush
@endsection
