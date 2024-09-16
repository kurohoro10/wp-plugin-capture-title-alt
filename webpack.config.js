const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
	entry: {
		scripts: './assets/src/js/main-script.js'
	},
	output: {
		path: path.resolve(__dirname, 'assets/build'),
		filename: 'main-[name].js'
	},
	module: {
		rules:[
			{
				test:/\.js$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['@babel/preset-env'],
					},
				},
			},
			{
				test: /\.css$/,
				use: [
					MiniCssExtractPlugin.loader,
					'css-loader',
				],
			},
		],
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: 'main-style.css'
		})
	],
	mode: 'development',
	devServer: {
		static: {
			directory: path.resolve(__dirname, 'assets/build'),
			publicPath: '/assets/build',
		},
		compress: true,
		port:9000,
		hot: true,
		devMiddleware: {
			writeToDisk: true,
		},
	},
};
