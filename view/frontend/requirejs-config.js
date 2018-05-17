var config = {
    map: {
        '*': {
            'girit_lazyload_script': 'Girit_LazyLoad/js/girit_lazyload_script'
        }
    },
    deps: [
        "girit_lazyload_script"
    ],
    paths: {
        'girit_lazyload_script': 'Girit_LazyLoad/js/girit_lazyload_script',
        'jquery.lazyload': "Girit_LazyLoad/js/jquery.lazyload.min"
    },
    shim: {
        'jquery.lazyload': {
            deps: ['jquery']
        },
        'girit_lazyload_script': {
            deps: ['jquery', 'jquery.lazyload']
        }
    }
};