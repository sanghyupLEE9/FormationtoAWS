# FormationtoAWS
 formation test file 
 해당 파일들은 기본 인프라구성부터 원하는 Custom의 용도로 작성중이며 기호에 맞게 사용하면될것이다.
 
 기본적으로 VPC-EC2 파일을 받아 인프라를 구성하여 배포하여야한다.
 

VPC-EC2 : VPC configuration and test EC2 (bastion and webserver)



**# Systemmanager를 통하여 인스턴스의 ssh 접근을 Keypair없이 자유롭게 접근이가능한 템플릿이다.
**EC2-ssm : systemmanager Role configuration and Ec2 testing 



**# 개별 서버들에 대해서 CloudWatch Metric에 따른 SNS 알람 트리거 방식의 템플릿이다.
**monitoring : CloudWatch Metric Alert configuration 



**# 계정간의 CrossAccount role를 통해 관리하고자 하는 계정을 해당 Role을 배포해주어 관리자의 계정에서 언제든 SwitchRole할수있다.
**Crossaccount  : Crossaccount assume Role configuration



**# ALB-Autoscaling 구성으로 기본 AmazoneLinux2의 AMi를 통한 Userdata 커스텀을 통하여 Stress테스트를 진행한다.
**Loadbalancer : Loadbalncer and Autoscaling Configuration 
