({
    appDir: ".",
    mainConfigFile : 'config.js',
    dir : '../build',
    baseUrl : '../js',
    optimize : 'none',
    paths : {
        'assets' : '.',
        "daterangepicker": "empty:",
        "messages": "empty:",
    },

    modules : [
        {
            name: 'application'
        }
    ]
})