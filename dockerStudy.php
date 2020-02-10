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
	docker commit -m="提交的描述信息" -a="作者" [容器ID] [要创建的模板镜像名]:[标签名]
18、目录映射（可读可写）
	docker run -it -v /宿主机绝对路径目录:/容器内目录 [镜像名]
	18.1、目录映射（只读）
		docker run -it -v /宿主机绝对路径目录:/容器内目录:ro [镜像名]
