module.exports = {
    medias: {
        expand: true,
        cwd: '<%= assets %>/medias',
        src: ['**'],
        dest: '<%= dist %>/medias'
    },
    js_vendor: {
        expand: true,
        cwd: '<%= assets %>/js/vendor',
        src: ['**'],
        dest: '<%= dist %>/js'
    },
    css_fonts: {
        expand: true,
        cwd: '<%= assets %>/css/fonts',
        src: ['**'],
        dest: '<%= dist %>/css/fonts'
    },
    css_images: {
        expand: true,
        cwd: '<%= assets %>/css/images',
        src: ['**'],
        dest: '<%= dist %>/css/images'
    }
};
