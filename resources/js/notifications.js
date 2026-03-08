$(function() {
    console.log("hello");

window.Echo.channel('low-stock')
    .listen('App\\Events\\LowStockEvent', function(e) {
        console.log("Low stock alert received:", e);
            console.log(" Low stock alert received:", e);

            // Update notifications container
            let $container = $('#notifications');
            if ($container.length) {
                $container.prepend(`
                    <div class="p-2 border-b">
                        <strong>${e.part_name}</strong> (${e.variant_value})<br>
                        Stock: ${e.stock}<br>
                        Warehouse: ${e.warehouse}<br>
                        Location: ${e.store_location}
                    </div>
                `);
            }

            // Update notification count
            let $bell = $('#notification-count');
            if ($bell.length) {
                $bell.text(parseInt($bell.text() || 0) + 1);
            }
        });
});





