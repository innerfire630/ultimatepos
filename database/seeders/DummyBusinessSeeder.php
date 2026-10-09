<?php

namespace Database\Seeders;

use App\NotificationTemplate;
use App\User;
use App\Utils\InstallUtil;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class DummyBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        $password = Hash::make('123456');

        // $timezone = 'America/Phoenix'
        // config(['app.timezone' => $timezone]);
        // date_default_timezone_set($timezone);

        $today = \Carbon::now()->format('Y-m-d H:i:s');
        $yesterday = \Carbon::now()->subDays(2)->format('Y-m-d H:i:s');
        $last_week = \Carbon::now()->subDays(7)->format('Y-m-d H:i:s');
        $last_15th_day = \Carbon::now()->subDays(15)->format('Y-m-d H:i:s');
        $last_month = \Carbon::now()->subDays(30)->format('Y-m-d H:i:s');

        $next_6_month = \Carbon::now()->addMonths(6)->format('Y-m-d');
        $next_12_month = \Carbon::now()->addMonths(12)->format('Y-m-d');
        $next_18_month = \Carbon::now()->addMonths(18)->format('Y-m-d');

        $start_of_week = \Carbon::now()->startOfWeek()->format('Y-m-d');
        $end_of_week = \Carbon::now()->endOfWeek()->format('Y-m-d');

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        $shortcuts = '{"pos":{"express_checkout":"shift+e","pay_n_ckeckout":"shift+p","draft":"shift+d","cancel":"shift+c","edit_discount":"shift+i","edit_order_tax":"shift+t","add_payment_row":"shift+r","finalize_payment":"shift+f","recent_product_quantity":"f2","add_new_product":"f4"}}';

        $prefixes = '{"purchase":"PO","stock_transfer":"ST","stock_adjustment":"SA","sell_return":"CN","expense":"EP","contacts":"CO","purchase_payment":"PP","sell_payment":"SP","business_location":"BL"}';

        $business = [
            ['id' => '1', 'name' => 'Awesome Shop', 'currency_id' => '2', 'start_date' => '2018-01-01', 'tax_number_1' => '3412569900', 'tax_label_1' => 'GSTIN', 'tax_number_2' => null, 'tax_label_2' => null, 'default_sales_tax' => null, 'default_profit_percent' => '25.00', 'owner_id' => '1', 'time_zone' => 'America/Phoenix', 'fy_start_month' => '1', 'accounting_method' => 'fifo', 'default_sales_discount' => '10.00', 'sell_price_tax' => 'includes', 'logo' => null, 'sku_prefix' => 'AS', 'enable_product_expiry' => '0', 'expiry_type' => 'add_expiry', 'on_product_expiry' => 'keep_selling', 'stop_selling_before' => '0', 'enable_tooltip' => '1', 'purchase_in_diff_currency' => '0', 'purchase_currency_id' => null, 'p_exchange_rate' => '1.000', 'transaction_edit_days' => '30', 'stock_expiry_alert_days' => '30', 'keyboard_shortcuts' => $shortcuts, 'pos_settings' => '{"disable_pay_checkout":0,"disable_draft":0,"disable_express_checkout":0,"hide_product_suggestion":0,"hide_recent_trans":0,"disable_discount":0,"disable_order_tax":0, "customer_display_screen":1, "display_screen_heading":"<h2 style=\"text-align: center;\">Welcome<\/h2>", "carousel_image_1":"1744193481_20662.jpg","carousel_image_2":"1744193481_9195778.jpg","carousel_image_4":"1744193481_14928.jpg","carousel_image_5":"1744193481_14931.jpg"}', 'enable_brand' => '1', 'enable_category' => '1', 'enable_sub_category' => '1', 'enable_price_tax' => '1', 'enable_purchase_status' => '1', 'enable_lot_number' => '0', 'default_unit' => null, 'enable_racks' => '0', 'enable_row' => '0', 'enable_position' => '0', 'enable_editing_product_from_purchase' => '1', 'sales_cmsn_agnt' => null, 'item_addition_method' => '1', 'enable_inline_tax' => '1', 'currency_symbol_placement' => 'before', 'enabled_modules' => '["purchases","add_sale","pos_sale","stock_transfers","stock_adjustment","expenses","account"]', 'date_format' => 'm/d/Y', 'time_format' => '24', 'ref_no_prefixes' => $prefixes, 'created_at' => '2018-01-04 02:15:19', 'updated_at' => '2018-01-04 02:17:08', 'common_settings' => null],
            ['id' => '2', 'name' => 'Awesome Pharmacy', 'currency_id' => '2', 'start_date' => '2018-04-10', 'tax_number_1' => '3412569900', 'tax_label_1' => 'VAT', 'tax_number_2' => null, 'tax_label_2' => null, 'default_sales_tax' => null, 'default_profit_percent' => '25.00', 'owner_id' => '4', 'time_zone' => 'America/Chicago', 'fy_start_month' => '1', 'accounting_method' => 'fifo', 'default_sales_discount' => null, 'sell_price_tax' => 'includes', 'logo' => null, 'sku_prefix' => 'AP', 'enable_product_expiry' => '1', 'expiry_type' => 'add_manufacturing', 'on_product_expiry' => 'stop_selling', 'stop_selling_before' => '0', 'enable_tooltip' => '1', 'purchase_in_diff_currency' => '0', 'purchase_currency_id' => null, 'p_exchange_rate' => '1.000', 'transaction_edit_days' => '30', 'stock_expiry_alert_days' => '30', 'keyboard_shortcuts' => $shortcuts, 'pos_settings' => null, 'enable_brand' => '1', 'enable_category' => '1', 'enable_sub_category' => '1', 'enable_price_tax' => '1', 'enable_purchase_status' => '1', 'enable_lot_number' => '1', 'default_unit' => '4', 'enable_racks' => '0', 'enable_row' => '0', 'enable_position' => '0', 'enable_editing_product_from_purchase' => '1', 'sales_cmsn_agnt' => null, 'item_addition_method' => '1', 'enable_inline_tax' => '0', 'currency_symbol_placement' => 'before', 'enabled_modules' => '["purchases","add_sale","pos_sale","stock_transfers","stock_adjustment","expenses","account"]', 'date_format' => 'm/d/Y', 'time_format' => '24', 'ref_no_prefixes' => $prefixes, 'created_at' => '2018-04-10 08:12:40', 'updated_at' => '2018-04-10 10:21:38', 'common_settings' => null],
            ['id' => '3', 'name' => 'Ultimate Electronics', 'currency_id' => '2', 'start_date' => '2018-04-10', 'tax_number_1' => '12548555003', 'tax_label_1' => 'GST', 'tax_number_2' => null, 'tax_label_2' => null, 'default_sales_tax' => null, 'default_profit_percent' => '25.00', 'owner_id' => '5', 'time_zone' => 'America/Chicago', 'fy_start_month' => '1', 'accounting_method' => 'fifo', 'default_sales_discount' => null, 'sell_price_tax' => 'includes', 'logo' => null, 'sku_prefix' => 'AE', 'enable_product_expiry' => '0', 'expiry_type' => 'add_expiry', 'on_product_expiry' => 'keep_selling', 'stop_selling_before' => '0', 'enable_tooltip' => '1', 'purchase_in_diff_currency' => '0', 'purchase_currency_id' => null, 'p_exchange_rate' => '1.000', 'transaction_edit_days' => '30', 'stock_expiry_alert_days' => '30', 'keyboard_shortcuts' => $shortcuts, 'pos_settings' => null, 'enable_brand' => '1', 'enable_category' => '1', 'enable_sub_category' => '1', 'enable_price_tax' => '1', 'enable_purchase_status' => '1', 'enable_lot_number' => '0', 'default_unit' => '5', 'enable_racks' => '0', 'enable_row' => '0', 'enable_position' => '0', 'enable_editing_product_from_purchase' => '1', 'sales_cmsn_agnt' => null, 'item_addition_method' => '1', 'enable_inline_tax' => '0', 'currency_symbol_placement' => 'before', 'enabled_modules' => '["purchases","add_sale","pos_sale","stock_transfers","stock_adjustment","expenses","account","subscription"]', 'date_format' => 'm/d/Y', 'time_format' => '24', 'ref_no_prefixes' => $prefixes, 'created_at' => '2018-04-10 10:46:15', 'updated_at' => '2018-04-10 11:53:35', 'common_settings' => '{"enable_product_warranty":"1","default_datatable_page_entries":"25"}'],
            ['id' => '4', 'name' => 'Awesome Services', 'currency_id' => '124', 'start_date' => '2018-03-10', 'tax_number_1' => '3412569900', 'tax_label_1' => 'GST', 'tax_number_2' => null, 'tax_label_2' => null, 'default_sales_tax' => null, 'default_profit_percent' => '25.00', 'owner_id' => '6', 'time_zone' => 'America/Chicago', 'fy_start_month' => '1', 'accounting_method' => 'fifo', 'default_sales_discount' => null, 'sell_price_tax' => 'includes', 'logo' => null, 'sku_prefix' => 'AS', 'enable_product_expiry' => '0', 'expiry_type' => 'add_expiry', 'on_product_expiry' => 'keep_selling', 'stop_selling_before' => '0', 'enable_tooltip' => '1', 'purchase_in_diff_currency' => '0', 'purchase_currency_id' => null, 'p_exchange_rate' => '1.000', 'transaction_edit_days' => '30', 'stock_expiry_alert_days' => '30', 'keyboard_shortcuts' => $shortcuts, 'pos_settings' => null, 'enable_brand' => '1', 'enable_category' => '1', 'enable_sub_category' => '0', 'enable_price_tax' => '1', 'enable_purchase_status' => '1', 'enable_lot_number' => '0', 'default_unit' => null, 'enable_racks' => '0', 'enable_row' => '0', 'enable_position' => '0', 'enable_editing_product_from_purchase' => '1', 'sales_cmsn_agnt' => null, 'item_addition_method' => '1', 'enable_inline_tax' => '0', 'currency_symbol_placement' => 'before', 'enabled_modules' => '["purchases","add_sale","pos_sale","expenses","account","service_staff"]', 'date_format' => 'm/d/Y', 'time_format' => '24', 'ref_no_prefixes' => $prefixes, 'created_at' => '2018-04-10 12:20:42', 'updated_at' => '2018-04-10 12:23:40', 'common_settings' => null],

            ['id' => '5', 'name' => 'Awesome Restaurant', 'currency_id' => '2', 'start_date' => '2018-07-12', 'tax_number_1' => '4578220005', 'tax_label_1' => 'IGST', 'tax_number_2' => '4593220009', 'tax_label_2' => 'SGST', 'default_sales_tax' => null, 'default_profit_percent' => '25.00', 'owner_id' => '7', 'time_zone' => 'America/Chicago', 'fy_start_month' => '1', 'accounting_method' => 'fifo', 'default_sales_discount' => null, 'sell_price_tax' => 'includes', 'logo' => null, 'sku_prefix' => 'AR', 'enable_product_expiry' => '0', 'expiry_type' => 'add_expiry', 'on_product_expiry' => 'keep_selling', 'stop_selling_before' => '0', 'enable_tooltip' => '1', 'purchase_in_diff_currency' => '0', 'purchase_currency_id' => null, 'p_exchange_rate' => '1.000', 'transaction_edit_days' => '30', 'stock_expiry_alert_days' => '30', 'keyboard_shortcuts' => $shortcuts, 'pos_settings' => '{"disable_pay_checkout":0,"disable_draft":0,"disable_express_checkout":0,"hide_product_suggestion":0,"hide_recent_trans":0,"disable_discount":0,"disable_order_tax":0, "customer_display_screen":1, "display_screen_heading":"<h2 style=\"text-align: center;\">Welcome<\/h2>", "carousel_image_1":"1744193481_20662.jpg","carousel_image_2":"1744193481_9195778.jpg","carousel_image_4":"1744193481_14928.jpg","carousel_image_5":"1744193481_14931.jpg"}', 'enable_brand' => '1', 'enable_category' => '1', 'enable_sub_category' => '1', 'enable_price_tax' => '1', 'enable_purchase_status' => '1', 'enable_lot_number' => '0', 'default_unit' => null, 'enable_racks' => '0', 'enable_row' => '0', 'enable_position' => '0', 'enable_editing_product_from_purchase' => '1', 'sales_cmsn_agnt' => null, 'item_addition_method' => '1', 'enable_inline_tax' => '0', 'currency_symbol_placement' => 'before', 'enabled_modules' => '["purchases","add_sale","pos_sale","stock_transfers","stock_adjustment","expenses","tables","modifiers","service_staff","kitchen","types_of_service","booking"]', 'date_format' => 'm/d/Y', 'time_format' => '24', 'ref_no_prefixes' => $prefixes, 'created_at' => '2018-07-13 16:42:11', 'updated_at' => '2018-07-13 07:38:24', 'common_settings' => null],
            ['id' => '6', 'name' => 'Manufacturers Demo', 'currency_id' => '124', 'start_date' => '2019-08-18', 'tax_number_1' => null, 'tax_label_1' => null, 'tax_number_2' => null, 'tax_label_2' => null, 'default_sales_tax' => null, 'default_profit_percent' => '25.00', 'owner_id' => '12', 'time_zone' => 'Asia/Kolkata', 'fy_start_month' => '1', 'accounting_method' => 'fifo', 'default_sales_discount' => null, 'sell_price_tax' => 'includes', 'logo' => null, 'sku_prefix' => null, 'enable_product_expiry' => '0', 'expiry_type' => 'add_expiry', 'on_product_expiry' => 'keep_selling', 'stop_selling_before' => '0', 'enable_tooltip' => '1', 'purchase_in_diff_currency' => '0', 'purchase_currency_id' => null, 'p_exchange_rate' => '1.000', 'transaction_edit_days' => '30', 'stock_expiry_alert_days' => '30', 'keyboard_shortcuts' => $shortcuts, 'pos_settings' => '{"disable_pay_checkout":0,"disable_draft":0,"disable_express_checkout":0,"hide_product_suggestion":0,"hide_recent_trans":0,"disable_discount":0,"disable_order_tax":0,"is_pos_subtotal_editable":0}', 'enable_brand' => '1', 'enable_category' => '1', 'enable_sub_category' => '1', 'enable_price_tax' => '1', 'enable_purchase_status' => '1', 'enable_lot_number' => '0', 'default_unit' => null, 'enable_racks' => '0', 'enable_row' => '0', 'enable_position' => '0', 'enable_editing_product_from_purchase' => '1', 'sales_cmsn_agnt' => null, 'item_addition_method' => '1', 'enable_inline_tax' => '0', 'currency_symbol_placement' => 'before', 'enabled_modules' => '["purchases","add_sale","pos_sale","stock_transfers","stock_adjustment","expenses"]', 'date_format' => 'm/d/Y', 'time_format' => '24', 'ref_no_prefixes' => $prefixes, 'created_at' => '2019-08-18 18:41:28', 'updated_at' => '2019-08-18 18:43:22', 'common_settings' => null],
        ];
        DB::table('business')->insert($business);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $installUtil = new InstallUtil();
        $installUtil->createExistingProductsVariationsToTemplate();

        DB::commit();
    }
}
