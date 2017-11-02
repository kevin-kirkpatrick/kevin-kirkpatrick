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
        'PUT': lambda dynamo, x: updateUser(dynamo, x["Username"], x["Password"]),
    }

    operation = event['httpMethod']
    if operation in operations:
        payload = event['queryStringParameters'] if operation == 'GET' else json.loads(event['body'])
        return respond(None, operations[operation](dynamo, payload))
    else:
        return respond('Unsupported method "{}"'.format(operation), responseCode='400')

'''
Attempts to update a To Do Item to the database
The 'event' parameter is expected to be in the following format:
{
  "ItemID": "c6af9ac6-7b61-11e6-9a41-93e8deadbeef",
  "Description": "Grade design documents",
  "DueDate": "2017-10-25T12:48:00.000Z",
  "IsComplete": false,
  "Priority": "2"
}'''
def updateUser(dynamo, Username, Password):
    dynamodb = boto3.resource('dynamodb', region_name='us-east-1')
    Users = dynamodb.Table('Users')

    # Update item in the database
    # Technically, we should be checking for just the attributes passed in. Not assuming all of them are there.
    Users.update_item(
        Key={'Username':Username},
        UpdateExpression="SET "
            "Password = :Password",
        ExpressionAttributeValues={
            ':Password': Password
        }
    )

    # Read the updated item back from the database and return it
    response = Users.scan(
        FilterExpression=Attr('Username').eq(Username)
    )

    return response['Items']