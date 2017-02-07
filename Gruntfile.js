module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    clean: {
      compile: ['htdocs/TBBT-Projekt/**/*.phtml'],
    },
    jade4php: {
      compile: {
        options: {
          pretty: true
        },
        expand: true,
        cwd: 'jade',
        src: ['**/*.jade', '!_**/*.jade', '!layout/*.jade', '!mixins/*.jade', '!includes/*.jade'],
        dest: 'templates/',
        ext: '.phtml'
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-jade4php');

  grunt.registerTask('default', ['clean','jade4php']);

};  