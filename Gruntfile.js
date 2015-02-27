module.exports = function(grunt) {

    require('time-grunt')(grunt);

    require('load-grunt-config')(grunt, {
        data: {
            assets: 'resources/assets',
            vendor: 'resources/assets/vendor',
            dist: 'public/dist'
        },
        configPath: 'resources/assets/grunt'
    });

    grunt.registerTask('version', function () {
        grunt.file.write('resources/assets/.version', (new Date()).getTime());
    });

    grunt.registerTask('dev', ['version', 'clean:dist', 'concat'/*, 'cssmin'*/, 'uglify'/*, 'copy' */]);
};
