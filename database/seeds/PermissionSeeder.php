<?php

use Illuminate\Database\Seeder;
use App\PermissionGroup;
use App\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $users_group = PermissionGroup::create(['name' => 'users permissions','title' => 'مدیریت کاربران']);
        $other_group = PermissionGroup::create(['name' => 'other permissions','title' => 'متفرقه']);
        $permissions_group = PermissionGroup::create(['name' => 'permissions management','title' => 'مدیریت دسترسی ها']);
        $pages_permissions = PermissionGroup::create(['name' => 'pages permissions','title' => 'مدیریت صفحات']);
        $article_permissions = PermissionGroup::create(['name' => 'article permissions','title' => 'مدیریت مقالات']);
        $article_categories_permissions = PermissionGroup::create(['name' => 'article category permissions','title' => 'مدیریت دسته بندی مقالات']);
        $menu_permissions = PermissionGroup::create(['name' => 'menu permissions','title' => 'مدیریت منو ها']);
        $slide_permissions = PermissionGroup::create(['name' => 'slide permissions','title' => 'مدیریت اسلاید ها']);
        $product_category_permissions = PermissionGroup::create(['name' => 'product category permissions','title' => 'مدیریت دسته بندی محصولات']);
        $brand_permissions = PermissionGroup::create(['name' => 'brand permissions','title' => 'مدیریت برندها']);
        $comment_permissions = PermissionGroup::create(['name' => 'comment permissions','title' => 'مدیریت نظرات']);
        $rate_permissions = PermissionGroup::create(['name' => 'rate permissions','title' => 'مدیریت امتیازات']);
        $product_permissions = PermissionGroup::create(['name' => 'product permissions','title' => 'مدیریت محصولات']);
        $attribute_permissions = PermissionGroup::create(['name' => 'attribute permissions','title' => 'مدیریت ویژگی ها']);
        $coupon_permissions = PermissionGroup::create(['name' => 'coupon permissions','title' => 'مدیریت کدهای تخفیف']);
        $contact_permissions = PermissionGroup::create(['name' => 'contact permissions','title' => 'مدیریت تماس ها']);
        $order_permissions = PermissionGroup::create(['name' => 'order permissions','title' => 'مدیریت سفارشات']);
        $tag_permissions = PermissionGroup::create(['name' => 'tag permissions','title' => 'مدیریت  برچسب ها']);

        Permission::create(['name' => 'view panel', 'title' => 'مشاهده پنل' , 'group_id' => $other_group->id]);
        Permission::create(['name' => 'view options', 'title' => 'مشاهده تنظیمات' , 'group_id' => $other_group->id]);
        Permission::create(['name' => 'view file manager', 'title' => 'مشاهده رسانه' , 'group_id' => $other_group->id]);

        Permission::create(['name' => 'create order', 'title' => 'ایجاد سفارش' , 'group_id' => $order_permissions->id]);
        Permission::create(['name' => 'view orders', 'title' => 'مشاهده سفارش' , 'group_id' => $order_permissions->id]);
        Permission::create(['name' => 'edit order', 'title' => 'ویرایش سفارش' , 'group_id' => $order_permissions->id]);
        Permission::create(['name' => 'delete order', 'title' => 'حذف سفارش' , 'group_id' => $order_permissions->id]);

        Permission::create(['name' => 'create tag', 'title' => 'ایجاد برچسب' , 'group_id' => $tag_permissions->id]);
        Permission::create(['name' => 'view tags', 'title' => 'مشاهده برچسب' , 'group_id' => $tag_permissions->id]);
        Permission::create(['name' => 'edit tag', 'title' => 'ویرایش برچسب' , 'group_id' => $tag_permissions->id]);
        Permission::create(['name' => 'delete tag', 'title' => 'حذف برچسب' , 'group_id' => $tag_permissions->id]);

        Permission::create(['name' => 'create contact', 'title' => 'ایجاد تماس' , 'group_id' => $contact_permissions->id]);
        Permission::create(['name' => 'view contacts', 'title' => 'مشاهده تماس' , 'group_id' => $contact_permissions->id]);
        Permission::create(['name' => 'edit contact', 'title' => 'ویرایش تماس' , 'group_id' => $contact_permissions->id]);
        Permission::create(['name' => 'delete contact', 'title' => 'حذف تماس' , 'group_id' => $contact_permissions->id]);

        Permission::create(['name' => 'create coupon', 'title' => 'ایجاد کوپن تخفیف' , 'group_id' => $coupon_permissions->id]);
        Permission::create(['name' => 'view coupons', 'title' => 'مشاهده کوپن تخفیف' , 'group_id' => $coupon_permissions->id]);
        Permission::create(['name' => 'edit coupon', 'title' => 'ویرایش کوپن تخفیف' , 'group_id' => $coupon_permissions->id]);
        Permission::create(['name' => 'delete coupon', 'title' => 'حذف کوپن تخفیف' , 'group_id' => $coupon_permissions->id]);

        Permission::create(['name' => 'create attribute', 'title' => 'ایجاد ویژگی' , 'group_id' => $attribute_permissions->id]);
        Permission::create(['name' => 'view attributes', 'title' => 'مشاهده ویژگی' , 'group_id' => $attribute_permissions->id]);
        Permission::create(['name' => 'edit attribute', 'title' => 'ویرایش ویژگی' , 'group_id' => $attribute_permissions->id]);
        Permission::create(['name' => 'delete attribute', 'title' => 'حذف ویژگی' , 'group_id' => $attribute_permissions->id]);

        Permission::create(['name' => 'create product', 'title' => 'ایجاد محصول' , 'group_id' => $product_permissions->id]);
        Permission::create(['name' => 'view products', 'title' => 'مشاهده محصول' , 'group_id' => $product_permissions->id]);
        Permission::create(['name' => 'edit product', 'title' => 'ویرایش محصول' , 'group_id' => $product_permissions->id]);
        Permission::create(['name' => 'delete product', 'title' => 'حذف محصول' , 'group_id' => $product_permissions->id]);

        Permission::create(['name' => 'create comment', 'title' => 'ایجاد نظر' , 'group_id' => $comment_permissions->id]);
        Permission::create(['name' => 'view comments', 'title' => 'مشاهده نظر' , 'group_id' => $comment_permissions->id]);
        Permission::create(['name' => 'edit comment', 'title' => 'ویرایش نظر' , 'group_id' => $comment_permissions->id]);
        Permission::create(['name' => 'delete comment', 'title' => 'حذف نظر' , 'group_id' => $comment_permissions->id]);

        Permission::create(['name' => 'create rate', 'title' => 'ایجاد امتیاز' , 'group_id' => $rate_permissions->id]);
        Permission::create(['name' => 'view rates', 'title' => 'مشاهده امتیاز' , 'group_id' => $rate_permissions->id]);
        Permission::create(['name' => 'edit rate', 'title' => 'ویرایش امتیاز' , 'group_id' => $rate_permissions->id]);
        Permission::create(['name' => 'delete rate', 'title' => 'حذف امتیاز' , 'group_id' => $rate_permissions->id]);

        Permission::create(['name' => 'create brand', 'title' => 'ایجاد برند' , 'group_id' => $brand_permissions->id]);
        Permission::create(['name' => 'view brands', 'title' => 'مشاهده برند' , 'group_id' => $brand_permissions->id]);
        Permission::create(['name' => 'edit brand', 'title' => 'ویرایش برند' , 'group_id' => $brand_permissions->id]);
        Permission::create(['name' => 'delete brand', 'title' => 'حذف برند' , 'group_id' => $brand_permissions->id]);

        Permission::create(['name' => 'create product category', 'title' => 'ایجاد دسته بندی محصول' , 'group_id' => $product_category_permissions->id]);
        Permission::create(['name' => 'view product categories', 'title' => 'مشاهده دسته بندی محصول' , 'group_id' => $product_category_permissions->id]);
        Permission::create(['name' => 'edit product category', 'title' => 'ویرایش دسته بندی محصول' , 'group_id' => $product_category_permissions->id]);
        Permission::create(['name' => 'delete product category', 'title' => 'حذف دسته بندی محصول' , 'group_id' => $product_category_permissions->id]);

        Permission::create(['name' => 'create slide', 'title' => 'ایجاد اسلاید' , 'group_id' => $slide_permissions->id]);
        Permission::create(['name' => 'view slides', 'title' => 'مشاهده اسلاید' , 'group_id' => $slide_permissions->id]);
        Permission::create(['name' => 'edit slide', 'title' => 'ویرایش اسلاید' , 'group_id' => $slide_permissions->id]);
        Permission::create(['name' => 'delete slide', 'title' => 'حذف اسلاید' , 'group_id' => $slide_permissions->id]);

        Permission::create(['name' => 'create menu', 'title' => 'ایجاد منو' , 'group_id' => $menu_permissions->id]);
        Permission::create(['name' => 'view menus', 'title' => 'مشاهده منو' , 'group_id' => $menu_permissions->id]);
        Permission::create(['name' => 'edit menu', 'title' => 'ویرایش منو' , 'group_id' => $menu_permissions->id]);
        Permission::create(['name' => 'delete menu', 'title' => 'حذف منو' , 'group_id' => $menu_permissions->id]);

        Permission::create(['name' => 'create article category', 'title' => 'ایجاد دسته بندی مقاله' , 'group_id' => $article_categories_permissions->id]);
        Permission::create(['name' => 'view article categories', 'title' => 'مشاهده دسته بندی مقاله' , 'group_id' => $article_categories_permissions->id]);
        Permission::create(['name' => 'edit article category', 'title' => 'ویرایش دسته بندی مقاله' , 'group_id' => $article_categories_permissions->id]);
        Permission::create(['name' => 'delete article category', 'title' => 'حذف دسته بندی مقاله' , 'group_id' => $article_categories_permissions->id]);

        Permission::create(['name' => 'create article', 'title' => 'ایجاد مقاله' , 'group_id' => $article_permissions->id]);
        Permission::create(['name' => 'view articles', 'title' => 'مشاهده مقاله' , 'group_id' => $article_permissions->id]);
        Permission::create(['name' => 'edit article', 'title' => 'ویرایش مقاله' , 'group_id' => $article_permissions->id]);
        Permission::create(['name' => 'delete article', 'title' => 'حذف مقاله' , 'group_id' => $article_permissions->id]);

        Permission::create(['name' => 'create page', 'title' => 'ایجاد صفحه' , 'group_id' => $pages_permissions->id]);
        Permission::create(['name' => 'view pages', 'title' => 'مشاهده صفحه' , 'group_id' => $pages_permissions->id]);
        Permission::create(['name' => 'edit page', 'title' => 'ویرایش صفحه' , 'group_id' => $pages_permissions->id]);
        Permission::create(['name' => 'delete page', 'title' => 'حذف صفحه' , 'group_id' => $pages_permissions->id]);

        Permission::create(['name' => 'create user', 'title' => 'ایجاد کاربر' , 'group_id' => $users_group->id]);
        Permission::create(['name' => 'view users', 'title' => 'مشاهده کاربر' , 'group_id' => $users_group->id]);
        Permission::create(['name' => 'edit user', 'title' => 'ویرایش کاربر' , 'group_id' => $users_group->id]);
        Permission::create(['name' => 'delete user', 'title' => 'حذف کاربر' , 'group_id' => $users_group->id]);
        Permission::create(['name' => 'edit user permissions', 'title' => 'ویرایش دسترسی کاربران' , 'group_id' => $users_group->id]);

        Permission::create(['name' => 'delete permission', 'title' => 'حذف دسترسی ها' , 'group_id' => $permissions_group->id]);
        Permission::create(['name' => 'edit permission', 'title' => 'ویرایش دسترسی ها' , 'group_id' => $permissions_group->id]);
        Permission::create(['name' => 'create permission', 'title' => 'ایجاد دسترسی ها' , 'group_id' => $permissions_group->id]);
        Permission::create(['name' => 'view permissions', 'title' => 'مشاهده دسترسی ها' , 'group_id' => $permissions_group->id]);
        Permission::create(['name' => 'delete permission group', 'title' => 'حذف گروه های دسترسی' , 'group_id' => $permissions_group->id]);
        Permission::create(['name' => 'edit permission group', 'title' => 'ویرایش گروه های دسترسی' , 'group_id' => $permissions_group->id]);
        Permission::create(['name' => 'create permission group', 'title' => 'ایجاد گروه های دسترسی' , 'group_id' => $permissions_group->id]);
        Permission::create(['name' => 'view permission groups', 'title' => 'مشاهده گروه های دسترسی' , 'group_id' => $permissions_group->id]);
        Permission::create(['name' => 'delete role', 'title' => 'حذف نقش ها' , 'group_id' => $permissions_group->id]);
        Permission::create(['name' => 'edit role', 'title' => 'ویرایش نقش ها' , 'group_id' => $permissions_group->id]);
        Permission::create(['name' => 'create role', 'title' => 'ایجاد نقش ها' , 'group_id' => $permissions_group->id]);
        Permission::create(['name' => 'view roles', 'title' => 'مشاهده نقش ها' , 'group_id' => $permissions_group->id]);
    }
}
