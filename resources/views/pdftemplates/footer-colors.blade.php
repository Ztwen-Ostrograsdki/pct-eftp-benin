<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Bande</title>
	
</head>
    <style>
        body {
            margin: 0;
        }
        .barre {
            display: flex;
            width: 100%;
            height: 8px;
        }
        .barre > div {
            flex: 1;
        }
        .vert { background-color: #22c55e; }   /* bg-green-500 */
        .jaune { background-color: #eab308; } /* bg-yellow-500 */
        .rouge { background-color: #dc2626; } /* bg-red-600 */
    </style>
</head>
<body>
    <div class="barre">
        <div class="vert"></div>
        <div class="jaune"></div>
        <div class="rouge"></div>
    </div>
</body>
</html>
