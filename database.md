# 数据库模型

## 用户表(users)

> 储存登陆用户的基本信息和权限。

| 字段名 | 类型 | 长度 | 默认值 | 键 | 描述 |
|:-----:|:----:|:------:|:-----------:|:-------:|:-----:|
|user_id|int| 10 |    |  主键 |  用户自增id
|open_id|int| 10 |    |  主键 |  微信用户对应公众号的唯一id
|username|varchar| 10 |     | | 用户名
|email|varchar| 30 |    |   | 邮箱
|phone|varchar| 11 |      |    |电话号码
|password|varchar| 60 |    |  | 散列密码加密
|remember_token|varchar| 100 |     |  |Laravel框架自带，用于记住登陆用户
|name|varchar| 20 |     |   | 用户姓名
|remark|varchar| 255 |      |    | 备注
|status|tinyInt| 4 |   1  |  | 状态 0：禁止登录 1:正常
|is_admin|tinyInt| 4 |  0  |   | 0：员工；<br>1：后台用户；2：系统管理员

---


## 员工表 (employees)

> 储存员工信息

| 字段名 | 类型 | 长度 | 默认值 | 键 | 描述 |
|:-----:|:----:|:------:|:-----------:|:-------:|:-----:|
|employee_id|int| 10 |    |  主键 |  员工自增id
|user_id|int| 10 |    |  外键 |  用户id
|title_id|int| 10 |    |  外键 |  职位id
|id|int| 10 |    |   |  自定义员工号
|name|int| 20 |    |   |  员工姓名
|ic|int| 18 |    |   |  身份证号
|dob|date|  |     | | 出生日期
|gender|char|  1 |     | | 性别  F:女；M:男
|nationality|varchar|  30 |     | | 国籍
|religion|varchar|  30 |     | | 宗教信仰
|email|varchar| 30 |    |   | 邮箱
|address|varchar| 80 |    |   | 住址
|address_postal|varchar| 10 |    |   | 邮编
|address_postal|varchar| 10 |    |   | 邮编
|phone|varchar| 11 |      |    |电话号码
|nok|varchar| 20 |    |  | 紧急联系人姓名
|nok|varchar| 11 |    |  | 紧急联系人电话
|status|tinyInt| 4 |     |  | 状态 0：离职 1:正常 2:重新考虑
|img|varchar| 50 |     |  | 头像储存位置
|date_joined|date|  |     |  | 入职日期

---


## 职位表 (titles)

> 用于储存职位头衔

| 字段名 | 类型 | 长度 | 默认值 | 键 | 描述 |
|:-----:|:----:|:------:|:-----------:|:-------:|:-----:|
|title_id|int| 10 |    |  主键 |  职位自增id
|name|varchar| 30 |     | | 职位名称简称
|full_name|varchar| 50 |     | | 职位名称全称
|status|tinyInt| 4 |   1  |  | 状态 0：停用 1:正常
|remark|varchar| 255 |      |    | 备注

---

## 部门表 (departments)

> 用于储存部门信息

| 字段名 | 类型 | 长度 | 默认值 | 键 | 描述 |
|:-----:|:----:|:------:|:-----------:|:-------:|:-----:|
|department_id|int| 10 |    |  主键 |  部门自增id
|name|varchar| 30 |     | | 部门名称 
|status|tinyInt| 4 |   1  |  | 状态 0：停用 1:正常
|remark|varchar| 255 |      |    | 备注

---

## 办公地点表 (sites)

> 用于储存部门信息

| 字段名 | 类型 | 长度 | 默认值 | 键 | 描述 |
|:-----:|:----:|:------:|:-----------:|:-------:|:-----:|
|site_id|int| 10 |    |  主键 |  办公地点自增id
|name|varchar| 30 |     | | 部门名称 
|status|tinyInt| 4 |   1  |  | 状态 0：停用 1:正常
|lat|double|  |      |    | 纬度
|lng|double|  |      |    | 经度
|address|varchar| 255 |      |    | 地址
|postal|varchar| 10 |      |    | 邮编
---

## 部门办公地点表 (department_site)

> 部门与办公地点的中间表，实现了一个部门有多个工作地点，一个工作地点有多个部门

| 字段名 | 类型 | 长度 | 默认值 | 键 | 描述 |
|:-----:|:----:|:------:|:-----------:|:-------:|:-----:|
|department_id|int| 10 |    |  外键 |  部门id
|site_id|int| 10 |    |  外键 |  办公地点id
---

## 时间段表 (shifts)

> 用于储存不同部门在不同地点上班的时间段

| 字段名 | 类型 | 长度 | 默认值 | 键 | 描述 |
|:-----:|:----:|:------:|:-----------:|:-------:|:-----:|
|shift_id|int| 10 |    |  主键 |  时间段自增id
|department_id|int| 10 |    |  外键 |  部门id
|site_id|int| 10 |    |  外键 |  办公地点id
|start_time|time|  |     | | 开始工作时间
|hour|tinyInt| 2 |     | | 工作小时
|minute|tinyInt| 2 |     | | 工作分钟
|status|tinyInt| 4 |   1  |  | 状态 0：停用 1:正常
|remark|varchar| 255 |      |    | 备注
---

## 员工部门表 (department_employee)

> 部门与员工的中间表，实现了一个员工在不同的部门工作

| 字段名 | 类型 | 长度 | 默认值 | 键 | 描述 |
|:-----:|:----:|:------:|:-----------:|:-------:|:-----:|
|department_id|int| 10 |    |  外键 |  部门id
|employee_id|int| 10 |    |  外键 |  员工id
---

## 请假类型表 (leave_types)

> 本表储存所有自定义的请假类型

| 字段名 | 类型 | 长度 | 默认值 | 键 | 描述 |
|:-----:|:----:|:------:|:-----------:|:-------:|:-----:|
|leave_type_id|int| 10 |    |  主键 |  请假类型自增id
|name|varchar| 100 |    |   |  显示名称
|remark|varchar| 255 |    |   |  备注
|status|tinyInt| 4 |   1  |  | 状态 0:不使用;1:正常
---

## 请假表 (leaves)

> 用于记录所有请假的排班

| 字段名 | 类型 | 长度 | 默认值 | 键 | 描述 |
|:-----:|:----:|:------:|:-----------:|:-------:|:-----:|
|leave_id|int| 10 |    |  主键 |  请假自增id
|employee_id|int| 10 |    |  外键 |  员工id
|type_id|int| 10 |    |  外键 |  请假类型id
|date|date|  |     | | 请假日期
|status|tinyInt| 4 |   1  |  | 状态 0:软删除;1:正常
|remark|varchar| 255 |    |   |  备注
---

## 排班表 (rosters)

> 用于记录所有排班

| 字段名 | 类型 | 长度 | 默认值 | 键 | 描述 |
|:-----:|:----:|:------:|:-----------:|:-------:|:-----:|
|roster_id|int| 10 |    |  主键 |  排班自增id
|employee_id|int| 10 |    |  外键 |  员工id
|shift_id|int| 10 |    |  外键 |  时间段id
|date|date|  |     | | 排班工作日期
|status|tinyInt| 4 |   1  |  | 状态 0:软删除;1:正常
---

## 考勤记录表 (attendances)

> 考勤记录

| 字段名 | 类型 | 长度 | 默认值 | 键 | 描述 |
|:-----:|:----:|:------:|:-----------:|:-------:|:-----:|
|attendance_id|int| 10 |    |  主键 |  考勤自增id
|employee_id|int| 10 |    |  外键 |  员工id
|shift_id|int| 10 |    |  外键 |  办公地点id
|department_id|int| 10 |    |  外键 |  部门id
|site_id|int| 10 |    |  外键 |  办公地点id
|date_time|datetime|  |     | | 打卡时间
|duty_date|date|  |     | | 工作日期
|status|tinyInt| 4 |   1  |  | 状态 1:正常;2:补卡;3:更改过
|mode|tinyInt| 4 |      |    | 打卡模式 1:上班；2:下班
---