Infrastructure as Code
===============
IAC란 Infrastructure as Code의 약자이며, 코드형 인프라 또는 인프라 코드화는 이름 자체에서 설명하듯이 인프라를 코드를 통해서 구성 및 설정하는 방법론입니다. 
AWS의 환경이나 OS등의 인프라를 구성할 때 코드 기반으로 작성하여 관리하거나 갱신하는 방식입니다.


## Lab Overview
1. CloudFormation이란?
2. CloudFortmation 작성법 및 Syntax 소개
3. 스택 생성 및 배포

## CloudFormation란?
CloudFormation 이란 AWS의 리소스들을 자동으로 생성해주는 IAC(Infrastructure as Code)이다.
즉, AWS의 리소스들을 미리 코드화 하여 배포를 쉽고 빠르게 하기위함이다.
이 밖에도 IAC도구도 존재하며 해당 가이드는 AWS의 Cloudformation을 다루도록 하겠다.


## CloudFormation
> ### 동작 순서
1. 템플릿 코드 작성
2. 템플릿 업로드
3. 스택 생성
4. 리소스 생성
5. 템플릿 형식 : JSON or YAML 


![image](https://user-images.githubusercontent.com/67955312/126926129-21b58ac5-8146-410d-bdae-e51ed2c86156.png)


### 템플릿 구조
    AWSTemplateFormatVersion: "version date"
    Description:
      String
    Metadata:
      template metadata
    Parameters:
      set of parameters
    Mappings:
      set of mappings
    Conditions:
      set of conditions
    Resources:
      set of resources
    Outputs:
      set of outputs
  
- AWSTemplateFormatVersion : 템플릿이 따르는 버전, 현재 2010-09-09 버전이 유일
- Description: 템플릿의 설정을 기술하는 부분, 항상 템플릿 버전 다음에 정의

      AWSTemplateFormatVersion: "2010-09-09"
      Description: VPC Configuration
- Metadata: 템플릿에 대한 추가 상세 정보 인스턴스에 대한 메타데이터나 Parameter값들에 대한 Grouping 목적으로 사용
      
      Metadata: #파라미터들의 그룹들을 Label 작업
        AWS::CloudFormation::Interface: 
          ParameterGroups: 
            - 
              Label: 
                default: "Network Configuration"
              Parameters: 
                - VpcCIDR
                - PubCIDR1
                - PubCIDR2
                - PriCIDR1
                - PriCIDR2
- Conditions: 스택 생성 또는 업데이트 시 특정 리소스 속성에 값이 할당되는지의 여부를 제어, 스택 환경이 prod인지 test인지에 따라 달라지는 리소스를 조건부로 생성 시 사용
     
      AWSTemplateFormatVersion: 2010-09-09
        Parameters:
          EnvType:
            Description: Environment type.
            Default: test
            Type: String
            AllowedValues:
              - prod
              - test
            ConstraintDescription: must specify prod or test.
        Conditions:
          CreateProdResources: !Equals 
            - !Ref EnvType
            - prod
- parameters: 스택 생성 및 업데이트 시 템플릿에 전달하는 값

      Parameters:   
        EnvironmentName: #변수값으로 저장하여 리소스들의 공통된 네임 지정
          Description: A common name for your resources
          Type: String 

        VpcCIDR:
          Description: Please enter the IP range (CIDR notation) for this VPC ex(10.0.0.0/16)
          Type: String
          Default: 10.0.0.0/16
          AllowedPattern: '((\d{1,3})\.){3}\d{1,3}/\d{1,2}'

        PubCIDR1:
          Description: Please enter the IP range (CIDR notation) ex(10.0.2.0/24)
          Type: String
          Default: 10.0.2.0/24
          AllowedPattern: '((\d{1,3})\.){3}\d{1,3}/\d{1,2}'
        PubCIDR2:
          Description: Please enter the IP range (CIDR notation) ex(10.0.4.0/24)
          Type: String
          Default: 10.0.4.0/24
          AllowedPattern: '((\d{1,3})\.){3}\d{1,3}/\d{1,2}'

        PriCIDR1:
          Description: Please enter the IP range (CIDR notation) ex(10.0.32.0/24)
          Type: String
          Default: 10.0.32.0/24
          AllowedPattern: '((\d{1,3})\.){3}\d{1,3}/\d{1,2}'
        PriCIDR2:
          Description: Please enter the IP range (CIDR notation) ex(10.0.64.0/24)
          Type: String
          Default: 10.0.64.0/24
          AllowedPattern: '((\d{1,3})\.){3}\d{1,3}/\d{1,2}' 
  

- Mappings: 조건부 파라미터값을 지정하는데 사용할 수 있는 Key-Value값의 매핑 리전별로 리소스를 달리할 시 사용

      Mappings:
        Regionmap:  
          ap-northeast-2:
            Linux2: ami-0f2c95e9fe3f8f80e
            window: ami-0685efd12a23690f5
- Resources:  AWS리소스 및 해당 리소스의 속성을 지정

      Resources:
      ########### VPC ####################
        VPC:
          Type: AWS::EC2::VPC
          Properties:
            CidrBlock: !Ref VpcCIDR
            EnableDnsHostnames: true
              Tags:
                - Key: Name
                  Value: !Sub ${EnvironmentName} VPC #변수값으로 저장된 이름호출

      ############### igw #####################
        InternetGateway:
          Type: AWS::EC2::InternetGateway
          Properties:
            Tags:
              - Key: Name
                Value: !Sub ${EnvironmentName} igw
- Outputs: 리소스 생성 후 받을 결과에 대해 정의
     
      Outputs:
        VPC:
          Description: A reference to the created VPC
          Value: !Ref VPC

        PublicSubnet1:
          Description: A reference to the public subnet in the 1st Availability Zone
          Value: !Ref PublicSubnet1
        PublicSubnet2:
          Description: A reference to the public subnet in the 2nd Availability Zone
          Value: !Ref PublicSubnet2

        PrivateSubnet1:
          Description: A reference to the private subnet in the 1st Availability Zone
          Value: !Ref PrivateSubnet1
        PrivateSubnet2:
          Description: A reference to the private subnet in the 2nd Availability Zone
          Value: !Ref PrivateSubnet2

### Formation 스택 배포 시 지정한 Parameter값을 Console에서 확인
  ![image](https://user-images.githubusercontent.com/67955312/127620152-e66062dc-76d6-4955-8bf7-f790d79d7304.png)
