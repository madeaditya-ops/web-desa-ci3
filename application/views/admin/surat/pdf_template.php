<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        .document {
            margin: 2.5cm 3cm 2.5cm 3cm;
        }

        /* Header surat - centered */
        .header {
            text-align: center;
            margin-bottom: 20pt;
        }

        .header .title {
            font-size: 14pt;
            font-weight: bold;
            margin: 0 0 15pt 0;
            text-align: center;
            text-transform: uppercase;
        }

        .header .number {
            font-size: 12pt;
            margin: 0 0 20pt 0;
            text-align: center;
        }

        /* Content - left aligned */
        .content {
            text-align: left;
            margin: 0;
            line-height: 1.5;
        }

        .content p {
            margin: 0 0 12pt 0;
            text-align: left;
        }

        /* Biodata table styling */
        .biodata-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15pt 0;
        }

        .biodata-table td {
            padding: 3pt 0;
            vertical-align: top;
            text-align: left;
        }

        .biodata-table .label {
            width: 150pt;
            font-weight: normal;
        }

        .biodata-table .separator {
            width: 10pt;
            text-align: center;
        }

        .biodata-table .value {
            text-align: left;
        }

        /* Footer surat */
        .footer {
            margin-top: 30pt;
            text-align: left;
        }

        /* Signature */
        .signature {
            margin-top: 40pt;
            text-align: right;
            position: relative;
        }

        .signature .location-date {
            text-align: right;
            margin-bottom: 60pt;
            font-weight: normal;
        }

        .signature .title {
            text-align: right;
            margin-bottom: 80pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .signature .name {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 10pt;
        }
    </style>
</head>
<body>
    <div class="document">
        <?= $content ?>
    </div>
</body>
</html>
