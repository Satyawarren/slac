<html>
<head>
	<title>SLAC Messenger - Powered by Yahoo!</title>
<style>
.contact{
	width:100%;
	padding:5px;
    -moz-user-select: -moz-none;
    -khtml-user-select: none;
    -webkit-user-select: none;
    -o-user-select: none;
    user-select: none;
}

.dummy{
	display:none;
}

		.black_overlay{
			display: none;
			position: absolute;
			top: 0%;
			left: 0%;
			width: 100%;
			height: 100%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}
		.white_content {
			display: none;
			position: absolute;
			top: 25%;
			left: 25%;
			width: 50%;
			height: 50%;
			padding: 16px;
			border: 16px solid orange;
			background-color: white;
			z-index:1002;
			overflow: auto;
		}
</style>
<script src="http://yui.yahooapis.com/3.4.0/build/yui/yui-min.js"></script> 
<script>
	function sendChat(textBox,chat_area){
		var text = document.getElementById(textBox).value;
		var chat = document.getElementById(chat_area);
		var dummy = chat.getElementsByClassName('dummy')[0];
		var newnode = document.createElement("div");
		newnode.setAttribute("class","chat-content");
		newnode.innerHTML = text;
		chat.insertBefore(newnode,dummy);	
		document.getElementById('textBox').setAttribute("value","");
	}
</script>
</head>
<body class="yui3-skin-sam">
		<div id="light" class="white_content"></div>
		<div id="fade" class="black_overlay"></div>
<div id="demo">
</div>

<script type="text/javascript">
YUI().use('tabview', 'escape', 'plugin', function(Y) {
	var el = document.getElementById('fade');
	el.addEventListener("click", closelightBox, false);
	function setAvailable(contact_id,state){
		var el = document.getElementById(contact_id).getElementsByClassName("availability")[0];
		if(state == "yes"){
			el.innerHTML = '<img src="images/aim_active.png" cid="'+contact_id+'" id="fraud"/>';
		}else{
			el.innerHTML = '<img src="images/aim_dark.png" cid="'+contact_id+'"id="fraud"/>';
		}
	}
	
	function showlightBox(content){
		document.getElementById('light').innerHTML = content;
		document.getElementById('light').style.display='block';
		document.getElementById('fade').style.display='block';
	}
	
	function closelightBox(){
		document.getElementById('light').style.display='none';
		document.getElementById('fade').style.display='none';
	}
	


    var Removeable = function(config) {
        Removeable.superclass.constructor.apply(this, arguments);
    };

    Removeable.NAME = 'removeableTabs';
    Removeable.NS = 'removeable';

    Y.extend(Removeable, Y.Plugin.Base, {
        REMOVE_TEMPLATE: '<a class="yui3-tab-remove" title="remove tab">x</a>',

        initializer: function(config) {
            var tabview = this.get('host'),
                cb = tabview.get('contentBox');

            cb.addClass('yui3-tabview-removeable');
            cb.delegate('click', this.onRemoveClick, '.yui3-tab-remove', this);

            // Tab events bubble to TabView
            tabview.after('tab:render', this.afterTabRender, this);
        },

        afterTabRender: function(e) {
            // boundingBox is the Tab's LI
            if(e.target.get('label') != "Contacts")
				e.target.get('boundingBox').append(this.REMOVE_TEMPLATE);
        },

        onRemoveClick: function(e) {
            e.stopPropagation();
            var tab = Y.Widget.getByNode(e.target);
            var el = document.getElementById((tab.get("from")));
            el.setAttribute("open","false");
            tab.remove();
        }
    });
	var touchContact = function(e) {
		e.preventDefault();
		var el = e.target;
		var elid = el.getAttribute("id");
		if(elid != "fraud"){
			if(el.getAttribute("open") == "false"){
				var tab = new Y.Tab({
					id: 'slac_'+elid,
					label: el.getAttribute("name"),
					from: elid,
				});
				var content = '<div class="content">Contact Details</div><div class="chat" id="chat_area_'+elid+'"><span class="dummy"></span><input type="text" id="textBox_'+elid+'"/><input type="submit" value="submit" onclick="sendChat(\'textBox_'+elid+'\',\'chat_area_'+elid+'\')"/></div>';
				tab.set('content',content);
				tab.set("from",el.getAttribute("id"));
				tabview.add(tab);
				el.setAttribute("open","true");
			}else{
				el.style.display = 'block';
			}			
		}else{
			showlightBox(el.getAttribute("cid"));
		}
		//alert('event: ' + e.type + ' target: ' + e.target.get('id')); 
	};
	var clickContact = function(e) {
		e.preventDefault();
		var el = e.target;
		if(el.getAttribute("open") == "false"){
			var tab = new Y.Tab({
				label: el.getAttribute("name"),
				from: el.getAttribute("id"),
				content: 'loading...',
			});
			tab.set("from",el.getAttribute("id"));
			tabview.add(tab);
			el.setAttribute("open","true");
		}else{
			el.style.display = 'block';
		}
		//alert('event: ' + e.type + ' target: ' + e.target.get('id')); 
	};
    var tabview = new Y.TabView({
		id:'slac_maintab',
        children: [{
			id:'slac_contactbox',
            label: 'Contacts',
            content: '<div id="dummy" class="dummy"> </div>'
        }],
        plugins: [Removeable]
    });
    
    
   tabview.render("#demo");
   var cb = Y.one('#slac_contactbox');
   var dum = Y.one('#dummy');
   var item = Y.Node.create('<div class="contact" name="Contact 1" id="contact_1" open="false"><span class="availability"></span>Contact 1<br/><span class="status"><em>Status Here</em></span></div>');
   cb.insertBefore(item,dum);
   //item.on('dblclick', clickContact);
   item.on('click', touchContact);
   setAvailable("contact_1","yes");
   
   var item = Y.Node.create('<div class="contact" name="Contact 2" id="contact_2" open="false"><span class="availability"></span>Contact 2</div>');
   cb.insertBefore(item,dum);
   //item.on('dblclick', clickContact);
   item.on('click', touchContact);
   setAvailable("contact_2","no");

   /*var tab = new Y.Tab({
        label: "Test Contact 1",
        content: 'loading...',
    });
    tabview.add(tab);
   var tab = new Y.Tab({
        label: "Test Contact 2",
        content: 'loading...',
    });
    tabview.add(tab);*/
});
</script>
</body>
</html>