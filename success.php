<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Order Successful — Print Ticket</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <style>
    /* Page background & container */
    body {
      margin: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      -webkit-font-smoothing: antialiased;
    }
    .container {
      background: white;
      padding: 3rem 2.5rem;
      border-radius: 18px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
      text-align: center;
      max-width: 760px;
      width: 100%;
      animation: fadeIn 0.5s ease;
    }
    h2 { color:#2c3e50; margin-bottom: 0.6rem; font-size: 2.1rem; }
    p  { color:#6c7a89; margin-bottom: 1.25rem; }

    /* Buttons - these are hidden in printed output */
    .controls { margin-top: 18px; }
    .btn {
      display: inline-block;
      padding: 12px 28px;
      margin: 6px;
      border-radius: 28px;
      font-weight: 600;
      text-decoration: none;
      cursor: pointer;
      border: none;
      box-shadow: 0 6px 18px rgba(52,152,219,0.15);
    }
    .btn-primary { background:#3498db; color:#fff; }
    .btn-secondary { background:#2ecc71; color:#fff; }
    .no-print { /* any element with this class will be hidden in the printed result */
      /* kept visible on screen for user interaction */
    }

    /* Ticket markup (this will be printed) */
    .ticket {
      text-align: left;
      margin-top: 18px;
      border: 1px dashed rgba(0,0,0,0.08);
      padding: 18px;
      border-radius: 10px;
      background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }
    .ticket header { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
    .ticket h3 { margin: 0; font-size: 1.1rem; color:#2c3e50; }
    .ticket .meta { text-align:right; font-size:0.95rem; color:#6c7a89; }
    table { width:100%; border-collapse: collapse; margin-top:10px; }
    th, td { padding: 8px 6px; font-size: 0.95rem; border-bottom: 1px solid rgba(0,0,0,0.06); }
    th { text-align:left; color:#34495e; font-weight:600; }
    .total-row td { font-weight:700; font-size:1rem; }

    @keyframes fadeIn {
      from { opacity:0; transform: translateY(12px); } to { opacity:1; transform: translateY(0); }
    }

    /* PRINT STYLES */
    @media print {
      /* hide everything except the printable ticket area */
      body * { visibility: hidden; }
      #printable-area, #printable-area * { visibility: visible; }
      /* center printable area on the printed page */
      #printable-area { position: absolute; left: 0; right: 0; margin: 0 auto; top: 0; }
      /* remove shadows / background for clean printing */
      .container { box-shadow: none; background: #fff; }
      .no-print { display: none !important; }
      @page { margin: 10mm; }
    }

    /* responsive */
    @media (max-width:480px) {
      .container { padding: 20px; }
      h2 { font-size: 1.6rem; }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Thank you for your order! 🎉</h2>
    <p>Your order has been placed successfully. Below is your ticket — use Print Ticket to print or save as PDF.</p>

    <!-- Printable area -->
    <div id="printable-area">
      <div class="ticket" id="billSection">
        <header>
          <h3>MyBookStore / Ticket</h3>
          <div class="meta">
            <!-- Replace these with server-side variables if you have them (see notes below) -->
            <div><strong>Order ID:</strong> <span id="orderId">#123456</span></div>
            <div><strong>Date:</strong> <span id="orderDate">2025-09-16</span></div>
          </div>
        </header>

        <!-- Customer info (optional) -->
        <div style="margin-bottom:10px;">
          <strong>Customer:</strong> <span id="custName">John Doe</span><br>
          <strong>Email:</strong> <span id="custEmail">john@example.com</span>
        </div>

        <!-- Items table -->
        <table aria-label="Ticket Items">
          <thead>
            <tr>
              <th>Item</th>
              <th style="width:80px; text-align:right;">Qty</th>
              <th style="width:120px; text-align:right;">Price</th>
            </tr>
          </thead>
          <tbody id="itemsBody">
            <!-- Example rows — replace / generate server side -->
            <tr>
              <td>Learning PHP (Paperback)</td>
              <td style="text-align:right;">1</td>
              <td style="text-align:right;">₹299.00</td>
            </tr>
            <tr>
              <td>JavaScript Cookbook</td>
              <td style="text-align:right;">1</td>
              <td style="text-align:right;">₹499.00</td>
            </tr>
            <tr class="total-row">
              <td style="text-align:left;">Total</td>
              <td></td>
              <td style="text-align:right;">₹798.00</td>
            </tr>
          </tbody>
        </table>

        <p style="margin-top:12px; color:#6c7a89; font-size:0.95rem;">
          Note: Keep this ticket for your records. For support email support@mybookstore.example
        </p>
      </div>
    </div>

    <!-- Controls: Return home + Print (these will be hidden inside the printed result) -->
    <div class="controls no-print">
      <a href="index.php" class="btn btn-secondary">Return to Home</a>
      <button id="printBtn" class="btn btn-primary" onclick="printTicket()">Print Ticket</button>
    </div>
  </div>

  <script>
    /**
     * printTicket()
     * - Primary behavior: open a new window with only the ticket HTML & styles and call print().
     * - Fallback: if popup is blocked, fallback to window.print() (the @media print CSS will hide non-ticket elements).
     */
    function printTicket() {
      const ticketEl = document.getElementById('billSection');
      if (!ticketEl) {
        alert('Printable section not found.');
        return;
      }

      // Clone styles needed for the printed ticket
      const styleTags = Array.from(document.querySelectorAll('style, link[rel="stylesheet"]'))
        .map(tag => tag.outerHTML).join('\n');

      const html = `
        <!doctype html>
        <html>
          <head>
            <meta charset="utf-8">
            <title>Print Ticket</title>
            ${styleTags}
            <style>
              /* Ensure the printed copy is clean (some browsers need this inline) */
              body { margin: 10mm; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color:#222; }
              .container, .ticket { box-shadow:none !important; background: #fff !important; }
            </style>
          </head>
          <body>
            ${ticketEl.outerHTML}
            <script>
              // auto print then close
              window.focus();
              window.print();
              // Some browsers block window.close() if not initiated by user gesture, so wrap in try/catch
              try { window.close(); } catch(e) {}
            <\/script>
          </body>
        </html>`;

      const popup = window.open('', '_blank', 'width=800,height=900');

      if (popup) {
        // Popup succeeded
        popup.document.open();
        popup.document.write(html);
        popup.document.close();
      } else {
        // Popup blocked — fallback to default print (our @media print hides non-ticket parts)
        window.print();
      }
    }

    /* Optional: If you have data from server, you can populate fields here.
       Example (uncomment and set those JS variables from server-side or inline script):
       document.getElementById('orderId').textContent = '<?= $order_id ?>';
       document.getElementById('orderDate').textContent = '<?= date("Y-m-d") ?>';
       // And dynamically build table rows inside itemsBody
    */
  </script>
</body>
</html>
