# hyperf-multi-env
hyperf 多环境变量共存 支持hyperf3.0
# 安装
```
composer require zyimm/hyperf-multi-env
```

# 使用

1. 同级.env 指定APP_ENV环境变量 比如APP_ENV=test 
2. 同级.env 建立与之匹配.env.test
3. 程序通过env()获取

# 注意
组件原理本质是监听框架BootApplication事件后触发指定env加载，该事件触发之前框架本身的.env和config已经被加载，所以要再次替换config中所用env相关配置。因而如下建议&须知：

1. .env 保存公共环境变量
2. .env.xx 避免与.env冲突
3. 即使指定APP_ENV=test .env.test不存在亦不会报错影响程序运行


# 版本约定

⚠️Hyperf 框架版本在3.0及以下，请安装1.x版本。（已不维护）

⚠️Hyperf 框架版本在3.0，请安装2.0.x版本。（已不维护）

Hyperf 框架版本在3.1及以上，请安装2.1.x版本。（维护中）
