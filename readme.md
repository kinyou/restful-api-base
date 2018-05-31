## 关于restful-api-base

restful-api-base 是一个基于laravel5.5框架为基准创建的一个快速开发api接口的骨架程序.

- 快速开发api接口.
- [整合dingo/api开发包,用于api的版本控制,限流,api文档快速生成](https://github.com/dingo/api).
- [整合tymondesigns/jwt-auth开发包,用于生成token认证请求api接口](https://github.com/tymondesigns/jwt-auth).
- 整合自定义的自动刷新token中间件.
- Laravel友好的单元测试.


## 如何安装

- git clone https://github.com/kinyou/restful-api-base.git
- cd restful-api-base && cp .env.example .env
- composer install
- 修改.env中数据库和dingo/api的相关配置
    - DB_DATABASE=数据库名
    - DB_USERNAME=用户名
    - DB_PASSWORD=密码
- 生成应用key:  php artisan key:generate
- 生成jwt的认证key:  php artisan jwt:secret
- 执行数据库迁移:  php artisan migrate
- 生成测试数据:   php artisan db:seed
- 查看路由:  php artisan api:routes
- 生成api接口说明文档:  php artisan api:docs --name apidoc --use-version v1 --output-file apidoc.md -vvv
- 运行phpunit单元测试生成代码覆盖率: ./vendor/bin/phpunit
- 使用postman测试相关接口

## 备注说明

- 默认生成的用户测试数据的密码统一为:123456
- 测试用户名:demo 密码 :123456
