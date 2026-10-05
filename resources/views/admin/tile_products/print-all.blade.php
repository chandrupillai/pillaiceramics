<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print All Tile Inventory Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm;
            }
            body {
                background: #fff;
                font-size: 11pt;
                color: #000;
            }
            .no-print {
                display: none !important;
            }
            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            th, td {
                border: 1px solid #000 !important;
                padding: 6px 10px !important;
            }
            th {
                background-color: #f2f2f2 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        body {
            padding: 20px;
        }
    </style>
</head>
<body onload="window.print();">

    <div class="d-flex justify-content-between align-items-center mb-3 no-print">
        <h5>Full Stock Inventory ({{ $products->count() }} Total Products)</h5>
        <div>
            <button onclick="window.print()" class="btn btn-primary btn-sm me-2">Print</button>
            <button onclick="window.close()" class="btn btn-secondary btn-sm">Close</button>
        </div>
    </div>

    <div class="text-center mb-3">
        <h3 class="fw-bold mb-1">Tile Inventory Stock Report</h3>
        <p class="text-muted small mb-0">Total Products: {{ $products->count() }} | Generated on: {{ now()->format('d M Y, h:i A') }}</p>
    </div>

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 45%;">Product Name</th>
                <th style="width: 25%;">Godown</th>
                <th style="width: 25%;">Quantity</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $product->product_name }}</strong>
                    </td>
                    <td>
                        {{ $product->godown->name ?? 'Main Godown' }}
                    </td>
                    <td>
                        {{ number_format($product->stock_quantity) }} boxes
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        No tile products found in inventory.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>