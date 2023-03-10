targetScope = 'subscription'

param prNumber string = 'latest'
param containerTag string = 'latest'
param dbServerRG string
param dbServerName string
param subnetID string
param planID string

param location string = 'Canada Central'

resource testRG 'Microsoft.Resources/resourceGroups@2021-01-01' = {
  name: 'collab_review_${prBranch}'
  location: location
}

module collab './collab-test-instance.yaml' = {
  name: 'collab-test-infra'
  scope: resourceGroup(testRG.name)
  params: {
    containerTag: containerTag
    prName: 'PR_${prNumber}'
    subnetID: subnetID
    planID: planID
    dbServerRG: dbServerRG
    dbServerName: dbServerName
  }
}
