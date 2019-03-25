class IconButton extends GraphicalEl{
	constructor(domRef, specs={}){
		super(domRef);		
		this.addListener("touchend", this.click, false);
		this.addListener("click",    this.click, false);
		for (let spec in specs) {
		  this[spec] = specs[spec];
		}
	}

	desctructor(){
		super.desctructor();
	}
	click(){
		alert("ok");
	}
}