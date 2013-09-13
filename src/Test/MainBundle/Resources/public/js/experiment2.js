       
// Obtiene la ul que contiene la colección de etiquetas
var collectionHolder = $('ul.trials');

// configura una enlace "Agregar una etiqueta"
var $addTrialLink = $('<a href="#" class="add_trial_link">Add a Trial</a>');
var $newLinkLi = $('<li></li>').append($addTrialLink);

jQuery(document).ready(function() {
    // Añade el ancla "Agregar una etiqueta" y las etiquetas li y ul
    collectionHolder.append($newLinkLi);

    // cuenta las entradas actuales en el formulario (p. ej. 2),
    // la usa como índice al insertar un nuevo elemento (p. ej. 2)
    collectionHolder.data('index', collectionHolder.find(':input').length);

    $addTrialLink.on('click', function(e) {
        // evita crear el enlace con una "#" en la URL
        e.preventDefault();

        // añade una nueva etiqueta form (ve el siguiente bloque de código)
        addTrialForm(collectionHolder, $newLinkLi);
    });
});

function addTrialForm(collectionHolder, $newLinkLi) {
    // Obtiene los datos del prototipo explicado anteriormente
    var prototype = collectionHolder.data('prototype');

    // Consigue el nuevo índice
    var index = collectionHolder.data('index');

    // Sustituye el '__name__' en el prototipo HTML para que
    // en su lugar sea un número basado en cuántos elementos hay
    var newForm = prototype.replace(/__name__/g, index);

    // Incrementa en uno el índice para el siguiente elemento
    collectionHolder.data('index', index + 1);

    // Muestra el formulario en la página en un elemento li,
    // antes del enlace 'Agregar una etiqueta'
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
}