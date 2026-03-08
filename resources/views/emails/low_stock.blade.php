<!DOCTYPE html>
<html>
<head>
    <title>Low Stock Alert - Stock Management System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        
        .app-name {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 5px;
        }
        
        .alert-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .alert-message {
            background-color: #fff5f5;
            border-left: 5px solid #e74c3c;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        
        .alert-title {
            font-size: 18px;
            font-weight: bold;
            color: #c0392b;
            margin-bottom: 10px;
        }
        
        .details-section {
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: bold;
            color: #495057;
            min-width: 140px;
        }
        
        .detail-value {
            color: #212529;
            text-align: right;
            flex: 1;
        }
        
        .stock-value {
            font-size: 20px;
            font-weight: bold;
            color: #e74c3c;
            background-color: #fff5f5;
            padding: 8px 15px;
            border-radius: 25px;
            border: 2px solid #e74c3c;
        }
        
        .action-section {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        
        .action-text {
            color: #856404;
            font-weight: bold;
            font-size: 16px;
            margin: 0;
        }
        
        .footer {
            background-color: #343a40;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
        
        .timestamp {
            color: #6c757d;
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
            font-style: italic;
        }
        
        /* Responsive design */
        @media only screen and (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 5px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .content {
                padding: 20px;
            }
            
            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .detail-value {
                text-align: left;
            }
            
            .stock-value {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="alert-icon">🔔</div>
            <h1>Low Stock Alert</h1>
            <div class="app-name">Stock Management System</div>
        </div>
        
        <div class="content">
            <div class="alert-message">
                <div class="alert-title">Attention</div>
                <p>One of your inventory items has reached a critically low stock level.</p>
            </div>
            
            <div class="details-section">
                <div class="detail-row">
                    <div class="detail-label">Part Name:</div>
                    <div class="detail-value"><strong>{{ $variant->part->part_name }}</strong></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Variant:</div>
                    <div class="detail-value">{{ $variant->value }}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Warehouse:</div>
                    <div class="detail-value">{{ $warehouseStock->warehouse->name }}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Current Stock:</div>
                    <div class="detail-value">
                        <span class="stock-value">{{ $warehouseStock->stock }}</span>
                    </div>
                </div>
            </div>
            
            <div class="action-section">
                <p class="action-text">
                    🔄 Please take necessary action to restock this item
                </p>
            </div>
            
            <div class="timestamp">
                This alert was generated automatically by the Stock Management System
            </div>
        </div>
        
        <div class="footer">
            <p>Stock Management System © 2024 | Automated Inventory Alert</p>
        </div>
    </div>
</body>
</html>