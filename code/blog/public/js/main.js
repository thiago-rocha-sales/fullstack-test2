$(function(){     

    $('#searchField').on('keyup', function(event) {
        event.preventDefault();

        var value = this.value;
        if (value.length >= 3) {
            var path = '/app/api/posts?title='+value;
            getPosts(path);
        }
        
    });
    
    $('body').on('click', 'a.btn', function(event) {
        event.preventDefault();
        var href = $(this).attr('href');

        if(href)
            getPosts(href);
    });

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
            new DomElement('<p>', {style:'width: 100%;'}, '',
                new DomElement('<img>', {src:'/app/storage/images/' + post.image}, '', [])),
            new DomElement('<p>', {class:'blog-post-meta'}, 'December 23, 2013 by Jacob', []),
            new DomElement('<h2>', {class:'blog-post-title'}, post.title, [])
        ];

        var divCard = new DomElement('<div>', {class:'blog-post'}, '',   nodes);
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
            var divleftcolumn = $('.blog-main');
            divleftcolumn.empty();

            for(var post of response.data) {
                var postElement = buildDomElement(post);
                var renderElement = renderHtml(postElement);
                divleftcolumn.append(renderElement);
            }
            var urlPrev = response.links.prev && '/app/' + response.links.prev.split('/').slice(3).join('/');
            var urlNext = response.links.next && '/app/' + response.links.next.split('/').slice(3).join('/');

            var nav = $('<nav class="blog-pagination">')
                .append($('<a class="btn btn-outline-primary">Older</a>').attr('href', urlPrev))
                .append($('<a class="btn btn-outline-primary">Newer</a>').attr('href', urlNext));

                divleftcolumn.append(nav);
        });
    };

    var main = function() {
        getPosts('/app/api/posts');
    }();
    
});

