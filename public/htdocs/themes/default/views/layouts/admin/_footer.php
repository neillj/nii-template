<script type="text/javascript" src="http://sandbox.ternarylabs.com/porthole/js/porthole.min.js"></script>
<script type="text/javascript">
	function onMessage(messageEvent) {
		if (messageEvent.data["handshake"]) {
			windowProxy.post({'handshake':true});
		}
		if (messageEvent.data["click"]) {
			$(messageEvent.data["click"]).get(0).click();
		}
		if (messageEvent.data["enter"]) {
			$(messageEvent.data["enter"]).val(messageEvent.data["value"]);
		}
		if (messageEvent.data["select"]) {
			$(messageEvent.data["select"]).val(messageEvent.data["value"]);
		}
	}
	var windowProxy;
	window.onload=function(){
		windowProxy = new Porthole.WindowProxy("http://tester.local/proxy.html");
		windowProxy.addEventListener(onMessage);
		windowProxy.post({
			'url': window.location.href.replace(/https?:\/\//i, "")
//			'height': $('body').height()
		});
	}
	
	function getNodeSelector(node){
		var selector = '';
		var body = true;
		while(node.prop('tagName') != 'BODY'){
			if(selector){
				selector = ' > '+selector;
			}
//			if(node.attr('id') !== undefined) {
//				selector = '#'+node.attr('id')+selector;
//				body = false;
//				break;
//			}
			selector = node.prop('tagName')+':eq('+node.siblings(node.prop('tagName')).andSelf().index(node)+')'+selector;
			node = node.parent();
		}
		if(body){
			selector = 'BODY > '+selector; 
		}
		return $.trim(selector);
	}
	
	jQuery(function($){
		$('body').on('change','input,textarea',function(){
			windowProxy.post({
				'field': $(this).val(),
				'for': $('label[for="'+$(this).attr('id')+'"]')
					.clone()    //clone the element
					.children() //select all the children
					.remove()   //remove all the children
					.end()  //again go back to selected element
					.text(),
				'node': getNodeSelector($(this))
			});
		});
		$('body').on('click','select',function(){
			windowProxy.post({
				'select': $(this).val(),
				'for': $('label[for="'+$(this).attr('id')+'"]')
					.clone()    //clone the element
					.children() //select all the children
					.remove()   //remove all the children
					.end()  //again go back to selected element
					.text(),
				'label': $(this).find('option[value="'+$(this).val()+'"]').text(),
				'node': getNodeSelector($(this))
			});
		});
		$('body').on('click','a,button',function(){
			windowProxy.post({
				'link': $(this).text(),
				'node': getNodeSelector($(this))
			});
		});
		$('body').on('click','input:submit',function(){
			windowProxy.post({
				'link': $(this).val(),
				'node': getNodeSelector($(this))
			});
		});
	});
</script>
</html>