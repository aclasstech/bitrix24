/**
 * @module crm/in-app-url/url
 */
jn.define('crm/in-app-url/url', (require, exports, module) => {
	const { Url } = require('in-app-url/url');
	const { CrmMobileUrl } = require('crm/in-app-url/url/mobile');

	/**
	 * @class CrmUrl
	 */
	class CrmUrl
	{
		constructor(props)
		{
			const { url } = props;

			this.controller = this.getUrlController({ ...props, url: new Url(url) });
		}

		static createUrl(props)
		{
			const crmUrl = new CrmUrl(props);

			return crmUrl.toString();
		}

		getUrlController(props)
		{
			return new CrmMobileUrl(props);
		}

		toString()
		{
			return this.controller.getUrl();
		}
	}

	module.exports = { CrmUrl };
});
