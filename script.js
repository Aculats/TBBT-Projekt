/**
 * Created by Jan on 09.02.2017.
 */
$(document).ready(function(){
    var schere = $('#schere');
    var stein = $('#stein');
    var papier = $('#papier');
    var echse = $('#echse');
    var spock = $('#spock');

    schere.click(function (e) {
        e.preventDefault();
        console.log(this.id);
    });

    stein.click(function (e) {
        e.preventDefault();
        console.log(this.id);
    });

    papier.click(function (e) {
        e.preventDefault();
        console.log(this.id);
    });

    echse.click(function (e) {
        e.preventDefault();
        console.log(this.id);
    });

    spock.click(function (e) {
        e.preventDefault();
        console.log(this.id);
    });
});