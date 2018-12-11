
## 规范笔记（新项目）
- 文件名字： namespase最后一级（单数） 作为该命名空间下文件的命名后缀
- mvc   M:model  V:view  C:controller 各司其职
- mysql
- 	不连表，不跨库连表， 操作sql,
-   表名带上适当的前缀, _最为表名 字段名分隔符 sql语句自查  (执行效率)
-   根据业务,考虑会有的数据量, 适当的维度分表
-   根据适当的业务，拆分数据库（数据库分类，如代理的 日志的...）
-   一表一model 文件, 增删改查 表数据只能在对应的model里面操作
- 多个接口都会使用到的逻辑可写Repositories中, 单个接口使用到的简单逻辑可以就写到控制器里
- 变量等 参照驼峰法命名规范命名
- 非万不得已的情况下拒绝硬编码，配置需走配置文件配置，后台配置等， 
- 代码的可读性 ：代码需要加上注释, 类  方法  参数  都需要加上注释。代码中关键位置也需加上注释，方便自己也方便其他人
- 完善项目 wiki 文档, 接口编写需要编写wiki技术文档，把技术沉淀下来
- 跨项目获取数据不能直接连接数据库获取操作数据，需要走接口api 获取操作数据

## 安装步骤
- git clone  http://renkui@git.yangeit.com/renkui/c2Admin.git
- 复制.env.example 为.env
- 配置.env里的数据库连接信息 (初始化 已配置 可查看修改 )
- composer update
- php artisan migrate
- php artisan db:seed
- php artisan key:generate
- 登录后台：host/admin   帐号：root  密码：123456

## 图片展示
- 后台主页
![Image text](https://raw.githubusercontent.com/github-muzilong/laravel55-layuiadmin/master/public/images/1.png)
- 用户
![Image text](https://raw.githubusercontent.com/github-muzilong/laravel55-layuiadmin/master/public/images/2.png)
- 权限
![Image text](https://raw.githubusercontent.com/github-muzilong/laravel55-layuiadmin/master/public/images/3.png)
- 消息推送
![Image text](https://raw.githubusercontent.com/github-muzilong/laravel55-layuiadmin/master/public/images/4.png)
