(function (window, document, $)
{
	function Tabs (el, options)
	{
		this.el          = el;
		this.$el         = $(el);
		this.$navigation = this.$el.find('nav ul');
		this.$tabs       = this.$el.children('div');

        this.options = $.extend({}, this.defaultOptions, this.$el.data());

		this._init();
	}

	Tabs.prototype.Version = 1.0;

	Tabs.prototype._init = function ()
	{
		this._events();
	};

	Tabs.prototype._events = function ()
	{	
		var self = this;

		this.$navigation.on('click', 'li', function (e)
		{
			var $trigger = $(this);

			if (!$trigger.hasClass('active'))
			{
				$trigger.addClass('active')
						.siblings('li').removeClass('active');

				self.$tabs.eq($trigger.children('a').data('tab-navigation') - 1).addClass('active')
					.siblings('div').removeClass('active');
			}

			return false;
		});
	};

	function Plugin (options)
	{
        return this.each(function ()
        {   
            var el   = $(this), 
                data = el.data('tabs');

            if (!data)
            {
                 el.data('tabs', (data = new Tabs(this, options)));
            }      
        });
	}

    $.fn.tmsTabs = Plugin;

    $(function ()
    {
    	$('[data-tms-tabs]').tmsTabs();
    });

}(window, document, jQuery));