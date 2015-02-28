module.exports = {
    options: {
        separator: '\n;\n'
    },
    css: {
        src: [
            '<%= vendor %>/bootstrap/dist/css/bootstrap.css',
            '<%= vendor %>/bootstrap/dist/css/bootstrap-theme.css'
        ],
        dest: '<%= dist %>/css/styles.css'
    },
    js: {
        src: [
            '<%= vendor %>/jquery/dist/jquery.js',
            '<%= vendor %>/bootstrap/dist/js/bootstrap.js',
            '<%= vendor %>/amcharts/dist/amcharts/amcharts.js',
            '<%= vendor %>/amcharts/dist/amcharts/funnel.js',
            '<%= vendor %>/amcharts/dist/amcharts/pie.js',
            '<%= vendor %>/amcharts/dist/amcharts/serial.js'/*,
            '<%= assets %>/js/frontend.js',
            '<%= assets %>/js/frontend.form.js',
            '<%= assets %>/js/run.js'*/
        ],
        dest: '<%= dist %>/js/scripts.js'
    }
};
