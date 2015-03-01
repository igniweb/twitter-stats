module.exports = function(grunt) {

    require('time-grunt')(grunt);

    require('load-grunt-config')(grunt, {
        data: {
            assets: 'resources/assets',
            vendor: 'resources/assets/vendor',
            dist: 'public/dist'
        }
    });

    grunt.registerTask('version', function () {
        grunt.file.write('resources/assets/.version', (new Date()).getTime());
    });

    grunt.registerTask('default', ['dev']);

    grunt.registerTask('dev', ['version', 'clean', 'concat', 'cssmin', 'uglify', 'copy']);
};
