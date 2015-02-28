module.exports = {
    options: {
        separator: '\n;\n'
    }/*,
    css: {
        src: [
            '<%= vendor %>/jquery.selectBoxIt/src/stylesheets/jquery.selectBoxIt.css',
            '<%= assets %>/css/style.css'
        ],
        dest: '<%= dist %>/css/styles.css'
    }*/,
    js: {
        src: [
            '<%= vendor %>/amcharts/dist/amcharts/amcharts.js',
            '<%= vendor %>/amcharts/dist/amcharts/funnel.js'/*,
            '<%= assets %>/js/frontend.js',
            '<%= assets %>/js/frontend.form.js',
            '<%= assets %>/js/run.js'*/
        ],
        dest: '<%= dist %>/js/scripts.js'
    }
};
