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
6、
