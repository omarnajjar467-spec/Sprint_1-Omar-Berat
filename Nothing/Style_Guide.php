<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Navigatiestructuur – Check-in Systeem</title>
    <!-- Google Fonts: Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet" />
    <style>
        /* ── Reset & Base ── */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: #e8eaed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
        }

        /* A4‑style card */
        .nav-doc {
            max-width: 794px;
            width: 100%;
            background: #ffffff;
            padding: 32px 40px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        /* ── Header ── */
        .header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
            padding-bottom: 16px;
            border-bottom: 2px solid #1A73E8;
        }
        .color-swatch-header {
            width: 48px;
            height: 48px;
            background: #1A73E8;
            border-radius: 6px;
            flex-shrink: 0;
        }
        .header-text h1 {
            font-size: 26px;
            font-weight: 700;
            color: #202124;
            letter-spacing: -0.3px;
        }
        .header-text .sub {
            font-size: 15px;
            font-weight: 400;
            color: #5f6368;
        }

        /* ── Tree View ── */
        .tree {
            font-family: 'Roboto', monospace;
            font-size: 16px;
            line-height: 2;
            color: #202124;
            padding: 8px 0;
        }

        .tree .root {
            font-weight: 700;
            color: #1A73E8;
            font-size: 19px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }
        .tree .root .icon {
            font-size: 22px;
        }

        .tree .branch {
            padding-left: 28px;
            position: relative;
            font-weight: 500;
            color: #1A73E8;
        }
        .tree .branch::before {
            content: "├── ";
            color: #9aa0a6;
            font-weight: 300;
        }
        .tree .branch:last-child::before {
            content: "└── ";
        }

        .tree .leaf {
            padding-left: 28px;
            position: relative;
            color: #3c4043;
        }
        .tree .leaf::before {
            content: "│   ";
            color: #9aa0a6;
            font-weight: 300;
        }
        .tree .leaf:last-child::before {
            content: "    ";
        }

        .tree .leaf-item {
            padding-left: 28px;
            position: relative;
            color: #3c4043;
        }
        .tree .leaf-item::before {
            content: "├── ";
            color: #9aa0a6;
            font-weight: 300;
        }
        .tree .leaf-item:last-child::before {
            content: "└── ";
        }

        .tree .nested {
            padding-left: 56px;
            position: relative;
            color: #3c4043;
        }
        .tree .nested::before {
            content: "│   ";
            color: #9aa0a6;
            font-weight: 300;
        }
        .tree .nested:last-child::before {
            content: "    ";
        }

        .tree .nested-item {
            padding-left: 56px;
            position: relative;
            color: #3c4043;
        }
        .tree .nested-item::before {
            content: "├── ";
            color: #9aa0a6;
            font-weight: 300;
        }
        .tree .nested-item:last-child::before {
            content: "└── ";
        }

        .tree .muted {
            color: #80868b;
            font-size: 14px;
            font-weight: 300;
        }

        .tree .badge {
            background: #e8f0fe;
            color: #1A73E8;
            font-size: 11px;
            font-weight: 500;
            padding: 1px 10px;
            border-radius: 12px;
            margin-left: 8px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-family: 'Roboto', sans-serif;
        }

        /* ── Legend ── */
        .legend {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid #e8eaed;
            font-size: 13px;
            color: #5f6368;
            display: flex;
            flex-wrap: wrap;
            gap: 8px 24px;
        }
        .legend span {
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .legend .code {
            font-family: monospace;
            color: #9aa0a6;
        }

        /* ── Responsive ── */
        @media (max-width: 640px) {
            .nav-doc {
                padding: 20px;
            }
            .tree {
                font-size: 14px;
                line-height: 2.1;
            }
            .tree .branch,
            .tree .leaf,
            .tree .leaf-item,
            .tree .nested,
            .tree .nested-item {
                padding-left: 16px;
            }
            .tree .nested,
            .tree .nested-item {
                padding-left: 32px;
            }
            .header {
                flex-wrap: wrap;
            }
            .header-text h1 {
                font-size: 20px;
            }
        }

        /* ── Print ── */
        @media print {
            body {
                background: #fff;
                padding: 20px;
            }
            .nav-doc {
                box-shadow: none;
                border: 1px solid #ddd;
                padding: 24px 32px;
            }
            .tree {
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>

<div class="nav-doc">

    <!-- Header -->
    <header class="header">
        <div class="color-swatch-header" aria-hidden="true"></div>
        <div class="header-text">
            <h1>⭐ Navigatiestructuur – Check‑in Systeem</h1>
            <div class="sub">Versie 1.0 – Omar Najjar</div>
        </div>
    </header>

    <!-- Tree View -->
    <div class="tree">

        <div class="root">
            <span class="icon">🏠</span> Home
        </div>

        <!-- Studenten -->
        <div class="branch">Studenten</div>
        <div class="leaf">Studentenlijst</div>
        <div class="leaf">Studentdetails</div>
        <div class="nested">Persoonlijke info</div>
        <div class="nested">Pasje <span class="badge">Card</span></div>
        <div class="nested" style="margin-bottom:2px;">Check-in geschiedenis</div>

        <!-- Check-in -->
        <div class="branch">Check-in</div>
        <div class="leaf">Scan pasje</div>
        <div class="leaf" style="margin-bottom:2px;">Resultaat <span class="muted">(Op tijd / Te laat)</span></div>

        <!-- Dagoverzicht -->
        <div class="branch">Dagoverzicht</div>
        <div class="leaf">Alle check-ins van vandaag</div>
        <div class="leaf" style="margin-bottom:2px;">Filteren op klas / student</div>

        <!-- Docent Login -->
        <div class="branch">Docent Login</div>
        <div class="leaf" style="margin-bottom:2px;">Dashboard <span class="muted">(alleen voor docenten)</span></div>

        <!-- Instellingen -->
        <div class="branch" style="margin-bottom:0;">Instellingen</div>
        <div class="leaf">Account instellingen</div>
        <div class="leaf" style="margin-bottom:0;">Systeem instellingen</div>

    </div>

    <!-- Legend -->
    <div class="legend">
        <span><span class="code">├──</span> hoofdniveau</span>
        <span><span class="code">└──</span> laatste item</span>
        <span><span class="code">│</span> voortzetting</span>
        <span><span class="badge" style="background:#e8f0fe;color:#1A73E8;font-size:11px;padding:1px 10px;border-radius:12px;">Badge</span> extra context</span>
    </div>

</div>

</body>
</html>