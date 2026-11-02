<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #0d6efd; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #0d6efd; }
        .header p { margin: 5px 0 0; color: #666; font-size: 11px; }
        .summary-box { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .summary-box td { background: #f8f9fa; border: 1px solid #dee2e6; padding: 10px; text-align: center; width: 50%; }
        .summary-box h3 { margin: 5px 0 0; color: #333; }
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #dee2e6; padding: 8px; text-align: left; }
        table.data-table th { background-color: #f1f3f5; color: #495057; font-weight: bold; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #aaa; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Sales Analytics & Report Summary</h2>
        <p>Generated on: {{ date('Y-m-d H:i:s') }} | Filter Month: {{ $request->get('month') ?: date('Y-m') }}</p>
    </div>

    <table class="summary-box">
        <tr>
            <td>
                <span style="color: #666; font-size: 10px;">TOTAL QUANTITY SOLD</span>
                <h3>{{ number_format($totalQuantity, 2) }}</h3>
            </td>
            <td>
                <span style="color: #666; font-size: 10px;">TOTAL TRANSACTIONS</span>
                <h3>{{ $totalTransactions }}</h3>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Sales Person</th>
                <th>Product & Type</th>
                <th>Quantity</th>
                <th>Bill Shop Name</th>
                <th>Vehicle Info</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->sale_date }}</td>
                    <td>{{ $item->salesPerson->name ?? 'N/A' }}</td>
                    <td>
                        <strong>{{ $item->product->product_name ?? 'N/A' }}</strong><br>
                        <small style="color: #666;">{{ $item->productType->name ?? 'General' }}</small>
                    </td>
                    <td><strong>{{ $item->quantity }}</strong></td>
                    <td>{{ $item->bill_shop_name }}</td>
                    <td>{{ $item->vehicle_info ?: 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #999;">No records found matching filters.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Tile Showroom Management System &copy; {{ date('Y') }}
    </div>

</body>
</html>