<!-- Main navigation -->
<div class="sidebar-category sidebar-category-visible">
    <div class="category-content no-padding">
        <ul class="navigation navigation-main navigation-accordion">
            <li>
                <a href="{{ route('admin.dashboard') }}"><i class="icon-home2"></i> <span>Dashboard</span></a>
            </li>

            <li class="navigation-header">
                <span>Commerce</span>
                <i class="icon-menu" title="Main pages"></i>
            </li>

            <li><a href="{{ route('product.index') }}">
                    <i class="icon icon-bike"></i><span>Products</span></a>
            </li>
            <li><a href="{{ route('brand.index') }}">
                    <i class="glyphicon glyphicon-tags"></i><span>Brands</span></a>
            </li>
            <li><a href="{{ route('coupon.index') }}">
                    <i class="glyphicon glyphicon-gift"></i><span>Coupons</span></a>
            </li>
            <li><a href="{{ route('lead.index') }}">
                    <i class="glyphicon glyphicon-magnet"></i><span>Leads</span></a>
            </li>

            <li class="navigation-header">
                <span>Others</span>
                <i class="icon-menu" title="Users"></i>
            </li>
            <li><a href="{{ route('country.index') }}">
                    <i class="glyphicon glyphicon-globe"></i><span>Countries</span></a>
            </li>
            <li><a href="{{ route('category.index') }}">
                    <i class="glyphicon glyphicon-barcode"></i><span>Category</span></a>
            </li>
        </ul>
    </div>
</div>
