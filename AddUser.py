from boto3.dynamodb.conditions import Key, Attr
import boto3
from datetime import date
from datetime import timedelta
import json
import uuid

print('Loading function')
dynamo = boto3.client('dynamodb')


# Builds a JSON response object
def respond(err, res=None, responseCode=None):
    return {
        'statusCode': responseCode if err else '200',
        'body': err if err else json.dumps(res),
        'headers': {
            'Content-Type': 'application/json',
        },
    }


def lambda_handler(event, context):
    '''Demonstrates a simple HTTP endpoint using API Gateway. You have full
    access to the request and response payload, including headers and
    status code.

    To scan a DynamoDB table, make a GET request with the TableName as a
    query string parameter. To put, update, or delete an item, make a POST,
    PUT, or DELETE request respectively, passing in the payload to the
    DynamoDB API as a JSON body.
    '''
    #print("Received event: " + json.dumps(event, indent=2))

    operations = {
        'POST': lambda dynamo, x: addUser(dynamo, x['Username'], x['Password']),
    }

    operation = event['httpMethod']
    if operation in operations:
        payload = event['queryStringParameters'] if operation == 'GET' else json.loads(event['body'])
        return respond(None, operations[operation](dynamo, payload))
    else:
        return respond(ValueError('Unsupported method "{}"'.format(operation)))

def addUser(dynamo, Username, Password):
    # You may need to change this to your region (i.e. 'us-east-2')
    dynamodb = boto3.resource('dynamodb', region_name='us-east-1')
    User = dynamodb.Table('Users')
    item = { "Username" : Username, "Password" : Password }
    User.put_item(Item=item)
    return item