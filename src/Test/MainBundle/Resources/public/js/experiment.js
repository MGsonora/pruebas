  function addTagForm(collectionHolder) {
            var prototype = collectionHolder.data('prototype');
            var index = collectionHolder.data('index');
            var newForm = prototype.replace(/__name__/g, index);

            collectionHolder.data('index', index + 1);

            // Display the form in the page in an li, before the "Add a tag" link li
            var $newFormLi = $('<div></div>').append(newForm);
            collectionHolder.append($newFormLi);
        }

        // Get the div that holds the collection of tags
        var collectionHolder = $('div.trials');

        // setup an "add a address" link
        var $newLinkLi = $('<a href="#" class="btn btn-mini btn-info add_trial_link"><i class="icon-plus icon-white"></i>Add Trial</a>');

        $(function(){

            // add the "add a address" anchor and li to the trials div
            collectionHolder.parent().append($newLinkLi);

            // count the current form inputs we have (e.g. 2), use that as the new
            // index when inserting a new item (e.g. 2)
            collectionHolder.data('index', collectionHolder.find(':input').length);

            $newLinkLi.on('click', function(e) {
                // prevent the link from creating a "#" on the URL
                e.preventDefault();

                // add a new address form (see next code block)
                addTagForm(collectionHolder);
            });

            $(document).on('click', '.close', function(){
                $(this).closest('.trial').fadeOut(500, function() {
                    $(this).remove();
                });
            });
        });