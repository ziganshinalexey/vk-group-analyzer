module.exports = {
    cssDest: './dist/build/css/atom.min.css',
    options: {
        namespace: '#root',
    },
    configs: {
        breakPoints: {
            sm: '@media screen and (min-width: 750px)',
            md: '@media screen and (min-width: 1000px)',
            lg: '@media screen and (min-width: 1200px)'
        },
        classNames: []
    }
};