module.exports = {
    bootstrap_fonts: {
        expand: true,
        cwd: '<%= vendor %>/bootstrap/dist/fonts',
        src: ['**'],
        dest: '<%= dist %>/fonts'
    }
};
