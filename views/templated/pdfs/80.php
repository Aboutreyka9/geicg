<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      color: #333;
      margin: 0;
      padding: 0;
    }
    .receipt-container {
      width: 80mm; /* Pour imprimante thermique */
      max-width: 100%;
      padding: 10px 15px;
      border: 1px solid #ddd;
    }
    .header {
      text-align: center;
      margin-bottom: 10px;
    }
    .header img {
      max-width: 70px;
      margin-bottom: 5px;
    }
    .header h2 {
      margin: 0;
      font-size: 16px;
      font-weight: bold;
    }
    .info {
      margin: 10px 0;
      font-size: 11px;
    }
    .info td {
      padding: 2px 5px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 5px;
      font-size: 11px;
    }
    th {
      background: #f5f5f5;
      text-align: left;
    }
    .paid {
      position: absolute;
      top: 50%;
      left: 20%;
      font-size: 40px;
      color: rgba(150, 150, 150, 0.3);
      transform: rotate(-30deg);
    }
    .totals {
      margin-top: 10px;
      width: 100%;
      font-size: 11px;
    }
    .totals td {
      padding: 3px 5px;
    }
    .payment-methods {
      margin-top: 15px;
      font-size: 11px;
    }
    .payment-methods td {
      padding: 3px 5px;
    }
    .footer {
      margin-top: 20px;
      text-align: center;
      font-size: 12px;
    }
  </style>
</head>
<body>
  <div class="receipt-container">
    <div class="header">
      <img src="logo.png" alt="Logo">
      <h2>RECEIPT</h2>
    </div>

    <table class="info">
      <tr>
        <td><b>RECEIPT #:</b> 00-000000</td>
        <td><b>BILL TO:</b> Customer Name</td>
      </tr>
      <tr>
        <td><b>INVOICE #:</b> 00-000000</td>
        <td>Customer ID</td>
      </tr>
      <tr>
        <td><b>DATE:</b> 06/11/2024</td>
        <td>City, ST 277<br>Phone: (000) 000-0000</td>
      </tr>
    </table>

    <table>
      <thead>
        <tr>
          <th>DESCRIPTION</th>
          <th>QTY</th>
          <th>PRICE</th>
          <th>AMOUNT</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Service Fee</td>
          <td>1</td>
          <td>150</td>
          <td>150.00</td>
        </tr>
        <tr>
          <td>Labor: 4 hours @ $50/hr</td>
          <td>4</td>
          <td>50</td>
          <td>200.00</td>
        </tr>
        <tr>
          <td colspan="4" style="height:60px;"></td>
        </tr>
      </tbody>
    </table>

    <div class="paid">PAID</div>

    <table class="payment-methods">
      <tr>
        <td><b>PAYMENT METHODS</b></td>
      </tr>
      <tr>
        <td>☑ CASH &nbsp; ☐ VISA &nbsp; ☐ MASTERCARD &nbsp; ☐ PAYPAL</td>
      </tr>
    </table>

    <table class="totals">
      <tr>
        <td style="text-align:right; width:80%;">SUBTOTAL:</td>
        <td>350.00</td>
      </tr>
      <tr>
        <td style="text-align:right;">TAX RATE:</td>
        <td>7%</td>
      </tr>
      <tr>
        <td style="text-align:right;">TAX:</td>
        <td>24.50</td>
      </tr>
      <tr>
        <td style="text-align:right; font-weight:bold;">TOTAL:</td>
        <td style="font-weight:bold;">374.50</td>
      </tr>
    </table>

    <div class="footer">
      <p>YOUR COMPANY NAME</p>
      <p>Street Address - City, ST ZIP</p>
      <p>Phone: (000) 000-0000 | www.website.com</p>
      <h3>Thank You</h3>
    </div>
  </div>
</body>
</html>
