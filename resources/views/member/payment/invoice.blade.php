<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .invoice-container {
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header .logo {
            max-width: 150px;
        }
        .header .company-details {
            text-align: right;
        }
        .company-details h2 {
            margin: 0;
            font-size: 24px;
        }
        .company-details p {
            margin: 5px 0;
            font-size: 14px;
        }
        .client-details, .invoice-details {
            margin-bottom: 20px;
        }
        .client-details h3, .invoice-details h3 {
            margin-bottom: 10px;
            color: #555;
        }
        .details-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .details-table th, .details-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .details-table th {
            background-color: #f5f5f5;
            text-align: left;
        }
        .total-section {
            width: 100%;
            margin-top: 20px;
        }
        .total-section table {
            width: 50%;
            float: right;
            border-collapse: collapse;
        }
        .total-section th, .total-section td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .total-section th {
            background-color: #f5f5f5;
            text-align: left;
        }
        .footer {
            clear: both;
            margin-top: 50px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header avec Logo et Détails de l'Entreprise -->
        <div class="header">
            {{-- <div class="logo">
                @if($settings->company_logo)
                    <img 
                        src="{{ asset('storage/' . str_replace('public/', '', $settings->company_logo) ) }}"
                        alt="Logo de l'entreprise" 
                        style="max-width: 100%;"
                    >
                @else
                    <h2>
                        {{ $settings->company_name }}
                    </h2>
                @endif
            </div> --}}
            <div class="company-details">
                <h2>{{ $settings->company_name ?? '' }}</h2>
                <p>
                    {{ $settings->company_address ?? '' }}
                </p>
                @if($settings->company_phone)
                    <p>
                        Téléphone : {{ $settings->company_phone }}
                    </p>
                @endif
                @if($settings->company_email)
                    <p>
                        Email : {{ $settings->company_email }}
                    </p>
                @endif
                @if($settings->company_siret)
                    <p>
                        SIRET : {{ $settings->company_siret }}
                    </p>
                @endif
            </div>
        </div>

        <!-- Détails de la Facture -->
        <div class="invoice-details">
            <h3>Facture</h3>
            <p><strong>Numéro de Facture :</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Date :</strong> {{ $invoice->created_at->format('d/m/Y') }}</p>
        </div>

        <!-- Détails du Client -->
        <div class="client-details">
            <h3>Informations Client</h3>
            <p><strong>Nom :</strong> {{ $order->customer_firstname }} {{ $order->customer_lastname }}</p>
            <p><strong>Adresse :</strong> {{ $order->customer_address }}, {{ $order->customer_postal_code }} {{ $order->customer_city }}</p>
            <p><strong>Email :</strong> {{ $order->customer_email }}</p>
            <p><strong>Téléphone :</strong> {{ $order->customer_phone }}</p>
        </div>

        <!-- Tableau des Produits/Services -->
        <table class="details-table">
            <thead>
                <tr>
                    <th>Produit/Service</th>
                    <th>Quantité</th>
                    <th>Prix HT (€)</th>
                    <th>Taxes (€)</th>
                    <th>Prix TTC (€)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $order->product_name }}</td>
                    <td>{{ $order->product_quantity }}</td>
                    <td>{{ number_format($order->price_ht, 2) }}</td>
                    <td>{{ number_format($order->taxes, 2) }}</td>
                    <td>{{ number_format($order->price_ttc, 2) }}</td>
                </tr>
                <!-- Ajoute d'autres lignes si nécessaire -->
            </tbody>
        </table>

        <!-- Section des Totaux -->
        <div class="total-section">
            <table>
                <tr>
                    <th>Total HT :</th>
                    <td>{{ number_format($order->price_ht, 2) }} €</td>
                </tr>
                <tr>
                    <th>Total Taxes :</th>
                    <td>{{ number_format($order->taxes, 2) }} €</td>
                </tr>
                <tr>
                    <th>Total TTC :</th>
                    <td>{{ number_format($order->price_ttc, 2) }} €</td>
                </tr>
            </table>
        </div>

        <!-- Mentions Légales -->
        <div class="footer">
            <p><strong>Mentions Légales :</strong></p>
            <p>
                Société : {{ $settings->company_name }}
                <br>
                @if($settings->company_address)
                Adresse : {{ $settings->company_address }}<br>
                @endif
                @if($settings->company_siret)
                SIRET : {{ $settings->company_address }}<br>
                @endif
                TVA Intracommunautaire : TVA non applicable, article 293 B du CGI
            </p>
            <p>
                Les paiements sont effectués instantanément via Stripe. Aucune pénalité de retard n'est applicable.
            </p>
            <p>
                En cas de litige, les tribunaux compétents seront ceux du lieu de résidence de l'auto-entrepreneur.
            </p>
        </div>

    </div>
</body>
</html>
