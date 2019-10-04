@customer
Feature: Adding referral
  As a Store Owner
  I want to welcome new referrals

  Background:
    Given the store operates on a single channel in "United States"
    And I am a logged in customer

  @ui
  Scenario: Adding referral
    When I go to the create referrer
    And I fill the Referrer Name with "Ömer"
    And I fill the Referrer Email with "omer@eresbiotech.com"
    And I add it
    Then I should be notified that the referral has been created

  @ui
  Scenario: Trying to add referral with existing email
    When there is an existing referral with "omer@eresbiotech.com" email
    When I go to the create referrer
    And I fill the Referrer Email with "omer@eresbiotech.com"
    And I try to add it
    Then I should be notified that there is already an existing referral with provided email

  @ui
  Scenario: Adding new referral with blank data
    When I go to the create referrer
    And I add it
    And I should be notified that "Referrer Name, Referrer Email" fields cannot be blank

  @ui
  Scenario: Add a customer registered in the system
    When there is a user "omer@eresbiotech.com"
    And I go to the create referrer
    And I fill the Referrer Name with "Ömer"
    And I fill the Referrer Email with "omer@eresbiotech.com"
    And I try to add it
    Then I should be notified that there is already an existing in customer referral with provided email
