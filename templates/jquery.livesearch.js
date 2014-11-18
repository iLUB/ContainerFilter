(function ($) {
	$.fn.liveUpdate = function (list, line) {
		return this.each(function () {
			new $.liveUpdate(this, list, line);
		});
	};

	$.liveUpdate = function (e, list, line) {
		this.field = $(e);
		this.line = line;
		this.list = $(list);
		this.top_element = undefined;

		if (this.list.length > 0) {
			this.init();
		} else {
			$('#block_containerfilter_0').hide();
		}
	};

	$.liveUpdate.prototype = {
		init:function () {
			var self = this;
			this.setupCache();
			this.field.parent().find('#resetContainerFilter').click(function (e) {
				self.field.val('');
				self.filter(e);
			});

			this.field.on('keyup keypress', function (e) {
				self.filter(e);
			});
			self.filter();
			this.field.closest('form').off('keyup keypress');
		},

		filter:function (e) {
			// open the top element when pressing enter (key code 13)
			if (e !== undefined) {
				var code = e.keyCode || e.which;
				if (code  == 13) {
					if (this.top_element !== undefined) {
						var url = this.top_element.find('h4.il_ContainerItemTitle > a');
						if (jQuery.type(url.attr('href')) === 'string') {
							window.location.href = url.attr('href');
						}
					}
					e.preventDefault();
					return;
				}
			}

			if ($.trim(this.field.val()) == '') {
				this.list.find(this.line).parent('.ilCLIRow1').show();
				this.list.find(this.line).parent('.ilCLIRow2').show();
				this.list.find(this.line + ' .subitem').show();
				this.list.find('.ilPDBlockSubHeader').show();
				this.field.parent().find('#resetContainerFilter').hide();
				this.top_element = this.rows[0];
				this.field.focus();
			} else {
				this.field.parent().find('#resetContainerFilter').show();
				this.displayResults(this.getScores(this.field.val().toLowerCase()));
			}
		},

		setupCache:function () {
			var self = this;
			this.rows = [];
			this.cache = [];
			this.list.find(this.line).each(function () {
				// TODO recursively look for children? Currently only one level of subitems is supported
				var $children = $(this).find('.subitem h4.il_ContainerItemTitle');
				var c = [];
				for (var i = 0; i < $children.length; i++) {
					c[i] = {txt : $($children[i]).text().toLowerCase()};
				}
				self.rows.push($(this));
				var item = {
					txt : $(this).find('h4.il_ContainerItemTitle').not('.subitem h4.il_ContainerItemTitle').text().toLowerCase(),
					children : c
				};
				self.cache.push(item);

			});
			this.cache_length = this.cache.length;
		},

		displayResults:function (scores) {
			var self = this;
			this.list.find(this.line).parent('.ilCLIRow1').hide();
			this.list.find(this.line).parent('.ilCLIRow2').hide();
			this.list.find('.ilPDBlockSubHeader').hide();
			$.each(scores, function (i, score) {
				self.rows[score.index].parent('.ilCLIRow1').show();
				self.rows[score.index].parent('.ilCLIRow2').show();

				var $subitems = self.rows[score.index].find('.subitem');
				$subitems.hide();
				for (var j = 0; j < score.children.length; j++) {
					$($subitems[score.children[j].index]).show();
				}
			});

			// Update the element that should be opened when pressing enter
			if (scores.length > 0) {
				this.top_element = self.rows[scores[0].index];
			} else {
				this.top_element = undefined;
			}
		},

		getScores:function (term) {
			var scores = [];
			for (var i = 0; i < this.cache_length; i++) {
				var score = this.cache[i].txt.score(term, 1);

				var child_scores = [];
				for (var j = 0; j < this.cache[i].children.length; j++) {
					var child_score = this.cache[i].children[j].txt.score(term, 1);
					if (child_score > 0) {
						child_scores.push({score : child_score, index : j});
					}
				}

				if (score > 0 || child_scores.length > 0) {
					scores.push({score : score, index : i, children : child_scores});
					console.log('term: ' + term + ' index: ' + i + ' score: ' + score + ' number of children: ' + child_scores.length)
				}
			}

			return scores;
		}
	}
})(jQuery);