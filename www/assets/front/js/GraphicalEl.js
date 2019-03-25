class GraphicalEl{
	listeners = {};
	DOM;                                  				 //link between js and DOM
	constructor(domRef){
		window.frugalElt[domRef] = this;             //make available from DOM
		//check if exist 
		var exist = document.querySelector(domRef);
		if (typeof(exist) == 'undefined' || exist == null){
			console.log(":/");
		}
		else this.DOM = exist;
	}

	desctructor(){
		//remove all listeners
		for (let listener in this.listeners) {
		  this.removeListener(listener);
		}
	}

	linkToDOM(domRef){
		this.DOM = document.querySelector(domRef);
	}

	addListener(listener, action){
		if (this.listeners.hasOwnProperty(listener)) this.removeListener(listener);
		this.listeners[listener] = action;
		this.DOM.addEventListener(listener, this.listeners[listener]);
	}
	removeListener(listener){
		console.log("removeListener(",listener,")");
		this.DOM.removeEventListener(listener, this.listeners[listener]);		
		delete this.listeners[listener];
	}
}