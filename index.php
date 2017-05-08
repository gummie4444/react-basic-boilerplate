<!doctype>
<html>
<head>
    <base href="/masterofpuppets/">
    <title>M.O.P.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Load libraries -->
    <!-- IE required polyfills, in this exact order -->
    <script src="node_modules/es6-shim/es6-shim.min.js"></script>
    <script src="node_modules/systemjs/dist/system-polyfills.js"></script>
    <script src="node_modules/angular2/es6/dev/src/testing/shims_for_IE.js"></script>
    <script src="node_modules/angular2/bundles/angular2-polyfills.js"></script>
    <script src="node_modules/systemjs/dist/system.src.js"></script>
    <script src="node_modules/rxjs/bundles/Rx.js"></script>
    <script src="node_modules/angular2/bundles/angular2.js"></script>
    <script src="node_modules/angular2/bundles/router.dev.js"></script>
    <script src="node_modules/angular2/bundles/http.js"></script>

    <link rel="stylesheet" href="src/fa/css/font-awesome.min.css">
    <link rel="stylesheet" href="src/css/mop.css">
</head>
<body>
<app>Loading...</app>

<script>
    System.config({
        packages: {
            app: {
                format: 'register',
                defaultExtension: 'js'
            }
        }
    });
    System.import('app/boot')
            .then(null, console.error.bind(console));
</script>
</body>
</html>