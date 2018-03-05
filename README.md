# JSBox-ipa-install.js
可通过 [JSBox](https://itunes.apple.com/us/app/workflow/id915249334?mt=8 "JSBox") 或 [Workflow](https://itunes.apple.com/us/app/workflow/id915249334?mt=8 "Workflow") 作为桥梁配合服务端程序在 iOS 上安装 ipa 包

## 服务端

1. 有一台自己的服务器或者 VPS ，在上面安装 PHP 环境，并且能通过 **HTTPS** 访问。（注意：必须是 https，不能用 http）

2. 把 `api.php` 和 `clear.php` 上传到你的服务器中

3. 修改 `api.php` 里的上传令牌（上传密码）

## JSBox 中使用方法

1. 把 `IPA 安装器.js` 导入 JSBox ，在 JSBox 中启动 `IPA 安装器` ，配置好 `api.php` 的访问地址和上传令牌（上传密码）

2. 在电脑上把需要的 ipa 文件备份到手机的 iCloud Drive 或者 Shu 这类文件管理器中

3. 在这些文件管理器中点击分享按钮，打开分享面板，把 ipa 文件导入到 JSBox 里，然后选择“IPA 安装器”进行安装

## Workflow 中使用方法

1. 在手机上用浏览器打开 [https://workflow.is/workflows/6cf7336d965b41549c911c898a12d031](https://workflow.is/workflows/6cf7336d965b41549c911c898a12d031 "https://workflow.is/workflows/6cf7336d965b41549c911c898a12d031") 链接安装 `IPA 安装器` 。安装时会要求填写 `api.php` 的访问地址和上传令牌（上传密码）

2. 直接运行 `IPA 安装器` 就可以从 iCloud Drive 或者 Dropbox 中选择备份好的 ipa 文件进行安装

3. 除了上面直接运行的方式外，还可以在 iCloud Drive 、Dropbox 、Shu 这些文件管理器中，打开分享面板，选择 `Run Workflow` 把 ipa 文件导入到 Workflow 里，然后选择“IPA 安装器”进行安装

## 其他说明

1. 源码中的接口所用的服务器是一台被我抛弃不用的国外 VPS ，网速和性能都比较渣，仅作为演示使用。所用我限制了 ipa 文件的最大尺寸，对于有条件的朋友可以自行部署服务端来配合客户端使用。

2. `IPA 安装器` 只是为可以在手机上方便的安装的 ipa 文件而提供的一个安装方式，它无法绕过苹果对 ipa 文件合法性的各种校验。也就是说，它无法安装盗版 ipa 文件！如果你的 ipa 文件是别人分享给你的，即使通过 `IPA 安装器` 安装到手机上了，在启动 App 后系统也会要求你输入当初下载这个 ipa 文件时使用的那个 Apple ID，否则无法使用。

3. 安装的 ipa 文件必须是在电脑上用 iTunes 下载的 ipa 文件，无法安装手机 App Store 中通过抓包下载的 ipa 文件。原因有两点，一是这种 ipa 文件是经过苹果特殊处理的 ipa 文件包，和电脑上用 iTunes 下载的 ipa 文件包不一样。就目前所知的情况来看，iOS 平台上也只有系统自身和[ Shu ](https://itunes.apple.com/us/app/shu-magic-file-viewer/id1282297037?mt=8 " Shu ") 这款 App 有能力解这种包，电脑上的各大手机助手都还无法做到。二是这种 ipa 文件包中缺少用户验证文件，即使通过其他方式安装到手机上了，App 也是无法启动的。**总而言之，需要安装的 ipa 文件必须是在电脑上用 iTunes 下载的 ipa 文件！**