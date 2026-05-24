<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; color: #333; }
        h1 { color: #1a2e44; border-bottom: 3px solid #00b4d8; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #1a2e44; color: #fff; }
        .total { font-size: 1.2rem; font-weight: bold; color: #00b4d8; }
        .footer { margin-top: 50px; font-size: .8rem; color: #999; text-align: center; }
    </style>
</head>
<body>
    <h1>🚗 AutoLouer — Facture</h1>
    <div style="display:flex;justify-content:space-between;margin-bottom:20px">
        <div>
            <strong>#FAC-{{ str_pad($facture->id, 4, '0', STR_PAD_LEFT) }}</strong><br>
            Date d'émission : {{ $facture->date_emission }}
        </div>
        <div>
            <strong>AutoLouer SARL</strong><br>
            Rabat, Maroc
        </div>
    </div>

    <h3>Client</h3>
    <p>
        {{ $facture->reservation->user->prenom }} {{ $facture->reservation->user->nom }}<br>
        {{ $facture->reservation->user->email }}<br>
        {{ $facture->reservation->user->telephone ?? '' }}
    </p>

    <h3>Détail de la location</h3>
    <table>
        <thead>
            <tr><th>Voiture</th><th>Période</th><th>Jours</th><th>Prix/j</th><th>Total</th></tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $facture->reservation->voiture->marque }} {{ $facture->reservation->voiture->modele }} ({{ $facture->reservation->voiture->annee }})</td>
                <td>{{ $facture->reservation->date_debut }} → {{ $facture->reservation->date_fin }}</td>
                <td>{{ $facture->reservation->nombreJours() }}</td>
                <td>{{ $facture->reservation->voiture->prix_par_jour }} MAD</td>
                <td class="total">{{ $facture->montant_total }} MAD</td>
            </tr>
        </tbody>
    </table>

    <p style="text-align:right;font-size:1.3rem"><strong>TOTAL : {{ $facture->montant_total }} MAD</strong></p>

    <div class="footer">
        Merci de votre confiance. Document généré automatiquement par AutoLouer.
    </div>
</body>
</html>