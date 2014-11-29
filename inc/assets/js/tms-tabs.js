(function (window, document)
{	
	if (!'bind' in Function.prototype)
	{
		Function.prototype.bind = function (context)
		{
			var fn   = this,
				args = Array.prototype.slice.call(arguments, 1);

			return function ()
			{
				return fn.apply(context, args);
			}
		}
	}

	function Tabs (el, options)
	{
		this.el         = el;
		this.navigation = this.el.querySelectorAll('nav ul li');
		this.tabs       = this.el.querySelectorAll('div.tms-tabs-content > section');
		this.currentTab = this._startIndex();

		this._init();
	}

	Tabs.prototype._init = function ()
	{
		this._events();
	};

	Tabs.prototype._startIndex = function ()
	{
		for (var i = 0, l = this.navigation.length; i < l; i++)
		{
			if (this.navigation[i].className === 'active')
			{
				return i;
			}
		}

		return 0;
	};

	Tabs.prototype._events = function ()
	{	
		for (var i = 0, l = this.navigation.length; i < l; i++)
		{	
			if (document.addEventListener !== undefined)
			{
				this.navigation[i].addEventListener('click', this._show.bind(this, this.navigation[i], i));
			}
			else
			{
				this.navigation[i].attachEvent('onclick', this._show.bind(this, this.navigation[i], i));
			}
		}
	};

	Tabs.prototype._show = function (el, index)
	{
		if (index === this.currentTab)
		{
			return false;
		}

		this.navigation[this.currentTab].className = '';
		this.tabs[this.currentTab].className = '';

		this.navigation[index].className = 'active';
		this.tabs[index].className = 'active';

		this.currentTab = index;
	}

	var els = document.querySelectorAll('[data-tms-tabs]');

	for (var i = 0, l = els.length; i < l; i++)
	{
		new Tabs(els[i])
	}

}(window, document));