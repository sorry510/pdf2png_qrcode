## pdf转图片+图片识别二维码(qrcode)

### 注意事项
1. 需要安装gswin64用于转换pdf为png图片,window下script提供有安装包
2. 使用zxing库来识别二维码，所以需要安装jdk
3. 需要配置java可执行路径，如果已配置为环境变量,可写如下代码
```
$decoder->setJavaPath('java');
```
4. window下的执行路径必须加上file协议,$path请使用绝对路径
```
$decoder->decode('file:///' . $path);
```