<?php
/*
1、docker镜像加速
sudo mkdir -p /etc/docker
sudo tee /etc/docker/daemon.json <<-'EOF'
{
    "registry-mirrors": [
        "https://1nj0zren.mirror.aliyuncs.com",
        "https://docker.mirrors.ustc.edu.cn",
        "http://f1361db2.m.daocloud.io",
        "https://registry.docker-cn.com"
    ]
}
EOF
sudo systemctl daemon-reload
sudo systemctl restart docker
详细使用：https://www.jianshu.com/p/5a911f20d93e


2、docker 拉去镜像，如果本地没就直接去源找镜像，并且下载称为镜像
docker run hellow-world
3、查看版本
docker verison
4、查看docker信息
docker info
5、查看镜像
docker images
	5.1、列出镜像里面的包含层
	docker images -a
	5.2、查看镜像的imagesid
	docker images -q
	5.3、docker注释
	docker images --digests
	5.3、查找镜像
	docker search python
	5.4、拉取镜像
	docker pull python
		5.4.1、如果指定版本
		docker pull python:3.6.5
	5.5、删除镜像
	docker rmi -f python,默认删除python:latest,如果删除指定3.6.5版本则：docker rmi -f python:3.6.5
6、创建容器
	docker pull centos
7、新建并启动容器
	docker run [option] [ImagesID]
	7.1、OPTION说明
		--name="容器名称"，为容器指定一个名称
		-d:后台运行容器，返回容器id,也就启动守护式容器
		-i:以交互模式运行容器，通常和-t同时使用
		-t:为容器重新分配一个伪输入终端，通常和-t同时使用
		-P[大写]：随机端口映射
		-p[小写]：指定端口映射
8、查看容器列表
	docker ps -a
9、退出容器
	exit 关闭并且退出
	ctrl+P+Q
10、关闭容器
	docker stop 容器ID
	10.1、强制停止
	docker kill 容器ID
11、删除容器
	docker rm 容器ID
	11、1：强制删除容器ID
	docker rm -f 容器ID
12、查看docker最新的3条日志
	docker logs -tf --tail 3
13、查看容器进程
	docker top 容器ID
14、查看容器内部细节
	docker inspect 容器ID
15、进入容器
	docker attach 容器ID
	15.1:不进入容器执行命令
		docker exec -it 容器ID ls -a /home
	15.2:进入容器
		docker exec -it 容器ID /bin/bash
16、容器内拷贝文件到主机上
	docker cp 容器ID:容器内路径 目的主机的路径
17、提交容器副本，使之成为一个新的容器镜像
	docker commit -m="测试提交" -a="jim" [容器ID] jim/tomcat01:1.1
	docker commit -m="提交的描述信息" -a="作者" [容器ID] [要创建的模板镜像名]:[标签名]
18、目录映射（可读可写）
	docker run -it -v /home/dataVolumeContainer:/dataVolumeContainer [镜像名] --privileged=true
	docker run -it -v /宿主机绝对路径目录:/容器内目录 [镜像名] --privileged=true
	18.1、目录映射（只读）
		docker run -it -v /宿主机绝对路径目录:/容器内目录:ro [镜像名]



<----------------------------------------------------------------------------------------------------->
dockerFile使用

1、VOLUME给镜像添加一个或多个数据卷
	VOLUME["/dataVolumeContainer","/dataVolumeContainer2","/dataVolumeContainer3"]
2、通过dockerFile生成镜像
	docker build -f ./dockerFile2 -t jim/centos:1.1 .
	docker build -f [路径] -t [新镜像名称]:[TAG] .
3、容器继承
	如：dc02继承dc01
		docker run -it --name dc02 --volumes-from dc01 jim/centos
		docker run -it --name = [容器名称] --volumes-from [被继承容器名称] [镜像]
4、docker构建步骤
	4.1、编写dockerFile文件
	4.2、docker bulid
	4.3、docker run
<----------------------------------------------------------------------------------------------------->
5、dockerfile保留字命令
	5.1、FROM:基础镜像，当前镜像是基于哪个镜像
	5.2、MAINTAINER:镜像维护者名称和邮箱
	5.3、RUN:容器构建时需要运行的命令
	5.4、EXPOSE:当前容器对外暴露的端口
	5.5、WORKDIR:指定在创建容器后，终端默认登录进来的工作目录，一个落脚点
	5.6、ENV:用来在构建镜像过程的环境变量
	5.7、ADD:将宿主目录下的文件拷贝进镜像并且ADD命令会自动处理URL和解压tar压缩包
	5.8、COPY:类似ADD，拷贝文件到镜像中，可不会解压
	5.9、VOLUME:容器数据卷，用于数据保存和持久化工作
	5.10、CMD:指定一个容器启动时运行的命令，如果多个CMD命令只会执行最后一个，CMD会被docker run之后的参数替代
	5.11、ENTRYPONIT:指定一个容器启动时运行的命令、在指定容器启动程序以及参数
	5.12、ONBUILD:当构建一个被dockerFile时运行命令，父镜像在被子继承后父镜像的onbulid会被处罚
6、测试案例
	  FROM centos
      MAINTAINER jim<1657210793@qq.com>
      ENV MYPATH /usr/local
      WORKDIR $MYPATH
      RUN yum -y install vim
      RUN yum -y install net-tools
      EXPOSE 80
      CMD echo $MYPATH
      CMD echo "success---------ok"
      CMD /bin/bash
7、docker安装mysql
	7.1、拉取镜像
		docker pull mysql:5.6
	7.2、运行镜像
		docker run -p 81:3306 --name mysql56 -v /Jim/dockermysql56/conf:/etc/mysql/conf.d -v /Jim/dockermysql56/logs:/logs -v /Jim/dockermysql56/data:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=123456 -d mysql:5.6
8、docker安装redis
	8.1、拉取镜像
		docker pull redis:3.2
	8.2、运行镜像
		docker run -p 6379:6379 -v /jim/dockerredis32/data:/data -v /jim/dockerredis32/conf/redis.conf:/usr/local/etc/redis/redis.conf -d redis:3.2 redis-server /usr/local/etc/redis/redis.conf --appendonly yes
	8.3、保存目录
		/jim/dockerredis32/conf/redis.conf，新建vi redis.conf
	8.4、下载配置文件
		wget https://raw.githubusercontent.com/antirez/redis/5.0/redis.conf -O redis.conf
	8.5、使用命令测试
		docker exec -it 67159ee8c926 redis-cli

