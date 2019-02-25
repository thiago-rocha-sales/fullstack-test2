$(function(){            

    class DomElement {
        constructor(tag, attributes, text, nodes) {
            this.tag = tag;
            this.attributes = attributes;
            this.text = text;
            this.nodes = nodes instanceof Array 
                && nodes || [nodes];
        }
    };

    var buildDomElement = function(post) {
        var nodes = [
            new DomElement('<p>', {}, post.body, []),
            new DomElement('<div>', {class:"fakeimg", height:"200px"}, '',
                new DomElement('<img>', {src:'/app/storage/images/' + post.image}, '', [])),
            new DomElement('<h5>', {}, 'Title description, Dec 7, 2017', []),
            new DomElement('<h2>', {}, post.title, [])
        ];

        var divCard = new DomElement('<div>', {class:'card'}, '',   nodes);
        return divCard;
    };

    var parseElement = function(domElement) {
        return $(domElement.tag).
                attr(domElement.attributes).
                text(domElement.text);
    };

    var renderHtml = function render (node, element) {     
        if (node instanceof Array) {
            if (node.length > 0) {
                var n = node.pop();
                var el = parseElement(n);

                if(n.nodes !== undefined && n.nodes.length > 0)    
                    element.append(render(n.nodes, el));
                else
                    element.append(el);

                return render(node, element);
            } else {
                return element;
            }
        } else {
            var el = parseElement(node);
            return render(node.nodes, el);
        }
    };

    var getPosts = function(uri) {
        $.get(uri, function(response, status) {
            var divleftcolumn = $('.leftcolumn');
            divleftcolumn.empty();

            for(var post of response.data) {
                var postElement = buildDomElement(post);
                var renderElement = renderHtml(postElement);
                divleftcolumn.append(renderElement);
            }
            var urlPrev = response.links.prev && '/app/' + response.links.prev.split('/').slice(3).join('/');
            var urlNext = response.links.next && '/app/' + response.links.next.split('/').slice(3).join('/');

            $('#pagPrev').attr('href', urlPrev);
            $('#pagNext').attr('href', urlNext);
        });
    };

    var main = function() {
        getPosts('/app/api/posts');
    }();

    // $.get('/app/api/posts', function(obj, status) {

    //     console.log(obj.links.next);
    //     var divleftcolumn = $('div.leftcolumn');
    //     divleftcolumn.empty();
        
    //     var divPag = $('#pag');

    //     var urlPrev = obj.links.prev && '/app/' + obj.links.prev.split('/').slice(3).join('/');
    //     var urlNext = obj.links.next && '/app/' + obj.links.next.split('/').slice(3).join('/');

    //     var aNext = $('<a href="' + urlNext +'">Next</a>');
    //     var aPrev = $('<a href="' + urlPrev +'">Prev</a>');

    //     divPag.append(aPrev);
    //     divPag.append(aNext);

    //     for(var post of obj.data) {            
            
    //         var divCard = $('<div class="card"></div>');
    //         var h2 = $('<h2>' + post.title + '</h2>');
    //         var h5 = $('<h5>Title description, Dec 7, 2017</h5>');
    //         divCard.append(h2);
    //         divCard.append(h5);

    //         var divImg = $('<div class="fakeimg" style="height:200px;"></div>');
    //         var img = $('<img src="/app/storage/images/' + post.image + '">');

    //         divImg.append(img);
    //         var divContent = $('<p>' + post.body + '</p>');

    //         divCard.append(divImg);
    //         divCard.append(divContent);

    //         divleftcolumn.append(divCard);
    //     }
    // });



    $('#searchField').on('keyup', function(event) {
        event.preventDefault();

        var value = this.value;
        if (value.length >= 3) {
            var path = '/app/api/posts?title='+value;
            getPosts(path);
        }
        
    });

    $('a').on('click', function(event) {
        event.preventDefault();
        var href = $(this).attr('href');

        if(href)
            getPosts(href);
    });
});

