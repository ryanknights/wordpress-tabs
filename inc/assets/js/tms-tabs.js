(function (window, document)
{
	function Tabs (el, options)
	{
		this.el         = el;
		this.navigation = this.el.querySelectorAll('nav ul li');
		this.tabs       = this.el.querySelectorAll('div.tms-tabs-content > section');
		this.currentTab = 0;

		this._init();
	}

	Tabs.prototype._init = function ()
	{
		this._events();
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

	Array.prototype.slice.call(document.querySelectorAll('[data-tms-tabs]')).forEach(function (el)
	{
		new Tabs(el);
	});

}(window, document));